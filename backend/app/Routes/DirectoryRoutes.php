<?php

namespace Nova\Routes;

class DirectoryRoutes extends \Phalcon\Mvc\Router\Group
{
    public function initialize()
    {
        $this->setPaths(array(
            "namespace" => "Nova\Controllers",
            "controller" => "directory",
        ));

        $this->setPrefix("/directories");

        $this->addGet("", array(
            "action" => "index"
        ));

        $this->addGet("/:int", array(
            "action" => "find",
            "id" => 1
        ));

        $this->addPost("", array(
            "action" => "create"
        ));

        $this->addPut("/:int", array(
            "action" => "save",
            "id" => 1
        ));

        $this->addDelete("/:int", array(
            "action" => "delete",
            "id" => 1
        ));
    }
}
