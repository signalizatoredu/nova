<?php

// Create and register the autoloader
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
    "Nova" => __DIR__ . "/../../app/",
));

$loader->register();
