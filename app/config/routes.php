<?php

$router = new \Phalcon\Mvc\Router();

$router->removeExtraSlashes(true);

$router->mount(new \Nova\Routes\DirectoryRoutes());
$router->mount(new \Nova\Routes\DirectoryTypeRoutes());
$router->mount(new \Nova\Routes\MovieRoutes());
$router->mount(new \Nova\Routes\SessionRoutes());

return $router;
