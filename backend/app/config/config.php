<?php

$config = new \Phalcon\Config(array(
    "application" => array(
        "controllersDir" => __DIR__ . "/../../app/Controllers/",
        "modelsDir"      => __DIR__ . "/../../app/Models/",
        "viewsDir"       => __DIR__ . "/../../app/Views/",
        "pluginsDir"     => __DIR__ . "/../../app/Plugins/",
        "libraryDir"     => __DIR__ . "/../../app/Library/",
        "cacheDir"       => __DIR__ . "/../../app/Cache/",
        "logsDir"        => __DIR__ . "/../../app/Logs/",
        "baseUri"        => "/",
    ),
));

$dbConfig = include(__DIR__ . "/dbconfig.php");
$config->merge($dbConfig);

return $config;
