<?php

namespace Nova\Routes;

class SessionRoutes extends \Phalcon\Mvc\Router\Group
{
    public function initialize()
    {
        $this->setPaths(array(
            "controller" => "Session",
            "namespace" => "Nova\Controllers",
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
