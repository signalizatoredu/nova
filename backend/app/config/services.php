<?php

use Phalcon\Crypt;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\DI\FactoryDefault;
use Phalcon\Logger\Adapter\File as LoggerAdapter;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;

use Nova\Plugins\Cors;
use Nova\Plugins\Security;
use Nova\Security\SessionAuthenticationProvider as AuthenticationProvider;

// The FactoryDefault Dependency Injector automatically register the
// right services providing a full stack framework
$di = new FactoryDefault();

// Setting up the router
$di->set("router", function () {
    $router = include __DIR__ . "/router.php";

    return $router;
});

// Setting up the dispatcher
$di->set("dispatcher", function () use ($di) {

    $eventsManager = $di->getShared("eventsManager");

    $cors = new Cors($di);

    $cors->setAllowedHeaders(array("Content-Type"));
    $cors->useCredentials(true);
    $cors->setMaxAge(60);

    $security = new Security($di);

    // Listen for events
    $eventsManager->attach("dispatch", $cors);
    $eventsManager->attach("dispatch", $security);

    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

// The URL component is used to generate all kind of urls in the application
$di->set("url", function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

// Setting up the view component
$di->set("view", function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        ".volt" => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                "compiledPath" => $config->application->cacheDir,
                "compiledSeparator" => "_"
            ));

            return $volt;
        }
    ));

    return $view;
}, true);

// Database connection is created based in the parameters
// defined in the configuration file
$di->set("db", function () use ($config) {
    return new DbAdapter(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ));
});

// If the configuration specify the use of metadata adapter use it
// or use memory otherwise
$di->set("modelsMetadata", function () use ($config) {
    return new MetaDataAdapter();
});

// Start the session the first time some component request the session service
$di->set("session", function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

// Auth
$di->set("auth", function () use ($di) {
    return new AuthenticationProvider($di);
});

// Crypt
$di->set("crypt", function () use ($config) {
    $crypt = new Crypt();
    $crypt->setKey($config->application->cryptSalt);

    return $crypt;
});

// Logger
$di->set("logger", function () use ($config) {
    return new LoggerAdapter($config->application->logsDir . "/debug.log");
});
