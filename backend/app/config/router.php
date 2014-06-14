<?php

$router = new \Phalcon\Mvc\Router();

$router->clear();
$router->removeExtraSlashes(true);

// Add default route
$router->add("/", array(
    "namespace" => "Nova\Controllers",
    "controller" => "index",
    "action" => "index",
));

// Add 404 route
$router->notFound(array(
    "namespace" => "Nova\Controllers",
    "controller" => "error",
    "action" => "notFound",
));

// Add CORS OPTIONS route
$router->addOptions("/:params", array(
    "namespace" => "Nova\Controllers",
    "controller" => "index",
    "action" => "cors",
));

$router->mount(new \Nova\Routes\DirectoryRoutes());
$router->mount(new \Nova\Routes\DirectoryTypeRoutes());
$router->mount(new \Nova\Routes\MovieRoutes());
$router->mount(new \Nova\Routes\SessionRoutes());

return $router;
