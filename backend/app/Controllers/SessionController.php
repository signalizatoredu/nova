<?php

namespace Nova\Controllers;

use Nova\Http\StatusCode as HttpStatusCode;
use Nova\Models\User;
use Nova\Object;

class SessionController extends ControllerBase
{
    private function registerSession($user)
    {
        $this->session->set("auth", array(
            "id" => $user->getId(),
            "username" => $user->getUsername(),
        ));
    }

    public function authenticateAction()
    {
        if ($this->request->isPost()) {
            $data = $this->getJsonRequest();

            $username = $data->username;
            $password = $data->password;

            $user = User::findFirstByUsername($username);

            if ($user) {
                if ($this->security->checkHash($password, $user->getPassword())) {
                    $this->registerSession($user);

                    return $this->statusCodeResponse(
                        HttpStatusCode::OK,
                        "Authentication successful"
                    );
                }
            }

            return $this->statusCodeResponse(
                HttpStatusCode::FORBIDDEN,
                "Wrong username or password."
            );
        }

        return $this->forward("error/forbidden");
    }

    public function deauthenticateAction()
    {
        if ($this->request->isDelete()) {
            $this->session->remove("auth");
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

                // Fix this shit.
                $user->setCreateTime("0000-00-00");

                if (!$user->save()) {
                    // Log error here

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
