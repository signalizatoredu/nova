<?php

namespace Nova\Routes
{
    class DirectoryRoutes extends \Phalcon\Mvc\Router\Group
    {
        public function initialize()
        {
            // Default paths
            $this->setPaths(array(
                "controller" => "Directory",
                "namespace" => "Nova\Controllers",
            ));

            $this->setPrefix("/directories");

            $this->addGet("", array(
                "action" => "findAll"
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
}
