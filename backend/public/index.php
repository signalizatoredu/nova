<?php

error_reporting(E_ALL);
date_default_timezone_set("UTC");

try {

    // Read the configuration
    $config = include __DIR__ . "/../app/config/config.php";

    // Read auto-loader
    include __DIR__ . "/../app/config/loader.php";

    // Read services
    include __DIR__ . "/../app/config/services.php";

    // Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
}
