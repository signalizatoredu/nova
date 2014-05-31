<?php

$router = new \Phalcon\Mvc\Router();

$router->clear();
$router->removeExtraSlashes(true);

// Add default route
$router->add("/", array(
    "controller" => "index",
    "action" => "index",
    "namespace" => "Nova\Controllers",
));

// Add 404 route
$router->notFound(array(
    "controller" => "error",
    "action" => "notFound",
    "namespace" => "Nova\Controllers",
));

$router->mount(new \Nova\Routes\DirectoryRoutes());
$router->mount(new \Nova\Routes\DirectoryTypeRoutes());
$router->mount(new \Nova\Routes\MovieRoutes());
$router->mount(new \Nova\Routes\SessionRoutes());

return $router;