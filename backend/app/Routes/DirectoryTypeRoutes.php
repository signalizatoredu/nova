<?php

namespace Nova\Routes;

class DirectoryTypeRoutes extends RouterGroupBase
{
    public function initialize()
    {
        $this->setPaths(array(
            "namespace" => "Nova\Controllers",
            "controller" => "directory_type",
        ));

        $this->setPrefix("/directory_types");

        $this->addGet("", array(
            "action" => "index"
        ));

        $this->addGet("/:int", array(
            "action" => "find",
            "id" => 1
        ));
    }
}
