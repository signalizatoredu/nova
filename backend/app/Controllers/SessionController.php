<?php

namespace Nova\Controllers;

use Nova\Models\User;

class SessionController extends ControllerBase
{
    private function registerSession($user)
    {
        $this->session->set("auth", array(
            "id" => $user->id,
            "username" => $user->username
        ));
    }

    public function loginAction()
    {
        if ($this->request->isPost()) {
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            $user = User::findByFirstUsername($username);

            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    $this->registerSession($user);

                    return $this->forward("index/index");
                }
            }

            $this->flash->error("Wrong username/password");
        }

        return $this->forward("index/index");
    }

    public function logoutAction()
    {
        $this->session->remove("auth");
        $this->flash->success("Goodbye!");

        return $this->forward("index/index");
    }
}
