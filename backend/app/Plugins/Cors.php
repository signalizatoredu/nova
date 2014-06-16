<?php

namespace Nova\Plugins;

use Phalcon\Config\Adapter\Json as JsonConfig;
use Phalcon\DI\Injectable;
use Phalcon\Http\Response as HttpResponse;

class Cors extends Injectable
{
    public function __construct($dependencyInjector)
    {
        $this->_dependecyInjector = $dependencyInjector;
    }

    public function getWhitelist()
    {
        if (!isset($this->persistent->corsWhitelist)) {
            $whitelist = new JsonConfig(__DIR__ . "/../config/whitelist.json");

            $this->persistent->corsWhitelist = $whitelist->whitelist;
        }

        return $this->persistent->corsWhitelist;
    }

    /**
     * Set CORS headers on response object
     *
     * @param Response response The response to modify
     *
     * @return Response
     */
    public function setHeaders(HttpResponse $response)
    {
        $response->setHeader("Access-Control-Allow-Credentials", "true");

        $origin = $this->request->getHeader("HTTP_ORIGIN");

        foreach ($this->getWhitelist() as $domain) {
            if ($origin == $domain) {
                $response->setHeader("Access-Control-Allow-Origin", $domain);
                break;
            }
        }

        return $response;
    }

    /**
     * Set CORS OPTIONS headers on response object
     *
     * @param Response response The response to modify
     *
     * @return Response
     */
    public function setOptionsHeaders(HttpResponse $response)
    {
        $response->setHeader("Access-Control-Allow-Headers", "Content-Type");
        $response->setHeader("Access-Control-Allow-Methods", "DELETE, GET, POST, PUT");

        return $response;
    }
}
