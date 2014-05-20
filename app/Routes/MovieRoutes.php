<?php

namespace Nova\Routes
{
    class MovieRoutes extends \Phalcon\Mvc\Router\Group
    {
        public function initialize()
        {
            $this->setPaths(array(
                "controller" => "Movies",
                "namespace" => "Nova\Controllers",
            ));

            $this->setPrefix("/movies");

            $this->addGet("/:int", array(
                "action" => "find",
                "id" => 1
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
}
