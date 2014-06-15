<?php

namespace Nova\Controllers;

use Nova\Http\StatusCode as HttpStatusCode;
use Nova\Models\AuthToken;
use Nova\Models\User;
use Nova\Object;

class SessionController extends ControllerBase
{
    public function authenticateAction()
    {
        if ($this->request->isPost()) {
            $data = $this->getJsonRequest();

            $username = $data->username;
            $password = $data->password;
            $remember = $data->remember;

            if ($this->auth->authenticate($username, $password, $remember)) {
                $obj = new Object();
                $auth = new Object();

                $auth->username = $username;
                $auth->authenticated = true;
                $obj->auth = $auth;

                return $this->jsonResponse($obj);
            }

            return $this->statusCodeResponse(
                HttpStatusCode::UNAUTHORIZED,
                "Wrong username or password."
            );
        }

        return $this->forward("error/forbidden");
    }

    public function deauthenticateAction()
    {
        if ($this->request->isDelete()) {
            $this->auth->deauthenticate();
        }
    }

    public function registerAction()
    {
        if ($this->request->isPost()) {
            $data = $this->getJsonRequest();

            $user = User::findFirstByUsername($data->username);

            if ($user) {
                return $this->statusCodeResponse(
                    HttpStatusCode::CONFLICT,
                    "The username is in use."
                );
            } else {
                $user = new User();

                $user->setUsername($data->username);
                $user->setPassword($this->security->hash($data->password));

                if (!$user->save()) {
                    foreach ($authToken->getMessages() as $message) {
                        $this->logger->log("Error when saving User: " . $message);
                    }

                    return $this->statusCodeResponse(
                        HttpStatusCode::UNPROCESSABLE_ENTITY,
                        "Something went wrong when registering the user."
                    );
                } else {
                    $data = new Object();

                    $data->user = new Object;
                    $data->user->id = $user->getId();
                    $data->user->username = $user->getUsername();

                    return $this->jsonResponse($data, HttpStatusCode::CREATED);
                }
            }
        }
    }
}
