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

        $this->addPost("/authentication", array(
            "action" => "authenticate"
        ));

        $this->addDelete("/authentication", array(
            "action" => "deauthenticate"
        ));

        $this->addPost("/register", array(
            "action" => "register"
        ));
    }
}
