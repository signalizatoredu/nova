<?php

$router = new \Phalcon\Mvc\Router();

$router->addGet("/movies/:int", array(
    "controller" => "movies",
    "action" => "find",
    "id" => 1
));

$router->addPost("/movies/:int/scrape", array(
    "controller" => "movies",
    "action" => "scrape",
    "id" => 1
));

$router->addPost("/login", array(
    "controller" => "session",
    "action" => "login"
));

$router->addGet("/logout", array(
    "controller" => "session",
    "action" => "logout"
));

$router->addGet("/movies/:int/poster/:int/:int", array(
    "controller" => "image",
    "action" => "poster",
    "id" => 1,
    "width" => 2,
    "height" => 3
));

// Directories
$router->addGet("/directories", array(
    "controller" => "directory",
    "action" => "findAll"
));

$router->addGet("/directories/:int", array(
    "controller" => "directory",
    "action" => "find",
    "id" => 1
));

$router->addPost("/directories", array(
    "controller" => "directory",
    "action" => "create"
));

$router->addPut("/directories/:int", array(
    "controller" => "directory",
    "action" => "save",
    "id" => 1
));

$router->addDelete("/directories/:int", array(
    "controller" => "directory",
    "action" => "delete",
    "id" => 1
));

$router->addGet("/directory_types", array(
    "controller" => "directory",
    "action" => "findAllDirectoryTypes"
));

$router->addGet("/directory_types/:int", array(
    "controller" => "directory",
    "action" => "findDirectoryType",
    "id" => 1
));

return $router;
