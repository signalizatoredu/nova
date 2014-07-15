<?php

namespace Nova\Routes;

class SessionRoutes extends RouterGroupBase
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

        $this->addPost("/verify", array(
            "action" => "verify"
        ));
    }
}
