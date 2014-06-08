<?php

namespace Nova\Controllers;

use Nova\Http\StatusCode as HttpStatusCode;
use Nova\Models\AuthToken;
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
                    $authToken = new AuthToken();

                    $authToken->setUserId($user->getId());
                    $authToken->setSeries(AuthToken::generateUuid());
                    $authToken->setToken(AuthToken::generateUuid());

                    $date = new \DateTime("now", new \DateTimeZone("UTC"));
                    $date->add(\DateInterval::createFromDateString("+20 minutes"));

                    $authToken->setExpirationDate($date->format('Y-m-d H:i:s'));

                    if (!$authToken->save()) {
                        foreach ($authToken->getMessages() as $message) {
                            $this->logger->log("Error when saving AuthToken: " . $message);
                        }

                        return $this->statusCodeResponse(
                            HttpStatusCode::INTERNAL_SERVER_ERROR
                        );
                    }

                    $obj = new Object();
                    $auth = new Object();

                    $auth->username = $user->getUsername();
                    $auth->series = $authToken->getSeries();
                    $auth->token = $authToken->getToken();
                    $obj->auth = $auth;

                    return $this->jsonResponse($obj);
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
            $data = $this->getJsonRequest();

            $username = $data->username;
            $series = $data->series;
            $token = $data->token;

            $user = User::findFirstByUsername($username);

            $authToken = AuthToken::findFirst(array(
                "conditions" => "user_id = :user_id: and series = :series: and token = :token:",
                "bind" => array(
                    "user_id" => $user->getId(),
                    "series" => $series,
                    "token" => $token,
                )
            ));

            if ($authToken) {
                $authToken->delete();
            }
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
