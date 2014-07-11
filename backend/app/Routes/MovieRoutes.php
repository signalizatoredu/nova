<?php

namespace Nova\Routes;

class MovieRoutes extends \Phalcon\Mvc\Router\Group
{
    public function initialize()
    {
        $this->setPaths(array(
            "namespace" => "Nova\Controllers",
            "controller" => "movie",
        ));

        $this->setPrefix("/movies");

        $this->addGet("", array("action" => "index"));

        $this->addGet("/:int", array(
            "action" => "find",
            "id" => 1
        ));

        $this->addPost("/scan", array(
            "action" => "scan"
        ));

        $this->addPost("/:int/scrape", array(
            "action" => "scrape",
            "id" => 1
        ));

        $this->addGet("/:int/poster/:int/:int", array(
            "controller" => "image",
            "action" => "poster",
            "id" => 1,
            "width" => 2,
            "height" => 3
        ));
    }
}
