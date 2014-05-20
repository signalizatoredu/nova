<?php

error_reporting(E_ALL);

try {
	// Read the configuration
	$config = include __DIR__."/app/config/config.php";

	$loader = new \Phalcon\Loader();

    $loader->registerNamespaces(array(
        "Nova" => "app/",
    ));

	$loader->register();

	// The FactoryDefault Dependency Injector automatically register
	// the right services providing a full stack framework
	$di = new \Phalcon\DI\FactoryDefault();

	// The URL component is used to generate all kind of urls in the application
	$di->set("url", function() use ($config) {
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri($config->application->baseUri);
		return $url;
	});

    // Setting default controller namespace
    $di->set("dispatcher", function() {

        // Return 404 when the controller or action is not found
        $eventsManager = new Phalcon\Events\Manager();

        $eventsManager->attach("dispatch", function($event, $dispatcher, $exception) {
            if ($event->getType() == 'beforeException') {
                switch ($exception->getCode()) {
                    case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(array(
                            "controller" => "error",
                            "action" => "notFound"
                        ));

                        return false;
                }
            }
        });

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace("Nova\Controllers");
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

    // Setting up the router
    $di->set("router", function() {
        $router = include __DIR__."/app/config/routes.php";
        return $router;
    });

	// Setting up the view component
	$di->set("view", function() use ($config) {
		$view = new \Phalcon\Mvc\View();
		$view->setViewsDir($config->application->viewsDir);
        $view->registerEngines(array(
            ".volt" => "Phalcon\Mvc\View\Engine\Volt"
        ));
		return $view;
	});

	// Database connection is created based in the parameters defined
	// in the configuration file
	$di->set("db", function() use ($config) {
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"dbname" => $config->database->dbname
		));
	});

	// If the configuration specify the use of metadata adapter use it
	// or use memory otherwise
	$di->set("modelsMetadata", function() use ($config) {
		if (isset($config->models->metadata)) {
			$metadataAdapter = "Phalcon\Mvc\Model\Metadata\\"
							 . $config->models->metadata->adapter;
			return new $metadataAdapter();
		} else {
			return new \Phalcon\Mvc\Model\Metadata\Memory();
		}
	});

	// Start the session the first time some component request the
	// session service
	$di->set("session", function() {
		$session = new \Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	});

	// Handle the request
	$application = new \Phalcon\Mvc\Application();
	$application->setDI($di);
	echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}
