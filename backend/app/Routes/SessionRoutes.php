<?php

namespace Nova\Routes;

class SessionRoutes extends \Phalcon\Mvc\Router\Group
{
    public function initialize()
    {
        $this->setPaths(array(
            "namespace" => "Nova\Controllers",
            "controller" => "session",
        ));

        $this->setPrefix("/");

        $this->addPost("/login", array(
            "action" => "login"
        ));

        $this->addGet("/logout", array(
            "action" => "logout"
        ));
    }
}
