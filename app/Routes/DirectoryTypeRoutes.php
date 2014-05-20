<?php

namespace Nova\Routes
{
    class DirectoryTypeRoutes extends \Phalcon\Mvc\Router\Group
    {
        public function initialize()
        {
            $this->setPaths(array(
                "controller" => "Directory",
                "namespace" => "Nova\Controllers",
            ));

            $this->setPrefix("/directory_types");

            $this->addGet("/", array(
                "action" => "findAllDirectoryTypes"
            ));

            $this->addGet("/:int", array(
                "action" => "findDirectoryType",
                "id" => 1
            ));
        }
    }
}
