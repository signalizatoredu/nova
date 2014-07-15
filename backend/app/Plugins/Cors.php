<?php

namespace Nova\Plugins;

use Phalcon\Config\Adapter\Json as JsonConfig;
use Phalcon\DI\Injectable;
use Phalcon\Events\Event;
use Phalcon\Http\Response as HttpResponse;
use Phalcon\Mvc\Dispatcher;

class Cors extends Injectable
{
    private $allowedHeaders = array();
    private $exposedHeaders = array();
    private $exposeHeaders = false;
    private $maxAge = false;
    private $useCredentials = false;

    public function __construct($dependencyInjector)
    {
        $this->_dependecyInjector = $dependencyInjector;
    }

    /**
     * Get the whitelist with allowed CORS domains
     *
     * @return array
     */
    private function getWhitelist()
    {
        if (!isset($this->persistent->corsWhitelist)) {
            $whitelist = new JsonConfig(__DIR__ . "/../config/whitelist.json");

            $this->persistent->corsWhitelist = $whitelist->whitelist;
        }

        return $this->persistent->corsWhitelist;
    }

    /**
     * Expose headers.
     *
     * Set the exposed headers with setExposedHeaders.
     *
     * @param boolean exposeHeaders
     * @return void
     */
    public function exposeHeaders($exposeHeaders)
    {
        $this->exposeHeaders = $exposeHeaders;
    }

    /**
     * Allow use of cookies.
     *
     * @param boolean useCredentials
     * @return void
     */
    public function useCredentials($useCredentials)
    {
        $this->useCredentials = $useCredentials;
    }

    /**
     * Set the allowed headers to be sent with a request.
     *
     * @param array headers
     * @return void
     */
    public function setAllowedHeaders(array $headers)
    {
        $this->allowedHeaders = $headers;
    }

    /**
     * Set the allowed headers to be exposed.
     *
     * @param array headers
     * @return void
     */
    public function setExposedHeaders(array $headers)
    {
        $this->exposedHeaders = $headers;
    }

    /**
     * Set the cache time for a preflight request in seconds.
     *
     * @param int seconds
     * @return void
     */
    public function setMaxAge($seconds)
    {
        $this->maxAge = $seconds;
    }

    /**
     * Add Access-Control-Allow-Credentials header to a response object. Will
     * only add the header if useCredentials was set to true.
     *
     * @param Response response
     * @return Response
     */
    public function addAllowCredentialsHeader(HttpResponse $response)
    {
        if ($this->useCredentials) {
            $response->setHeader("Access-Control-Allow-Credentials", "true");
        }

        return $response;
    }

    /**
     * Add Access-Control-Allow-Headers header to a response object.
     *
     * @param Response response
     * @return Response
     */
    public function addAllowHeadersHeader(HttpResponse $response)
    {
        if (!empty($this->allowedHeaders)) {
            $headers = implode($this->allowedHeaders, ",");
            $response->setHeader("Access-Control-Allow-Headers", $headers);
        }

        return $response;
    }

    /**
     * Add Access-Control-Allow-Methods header to a response object
     *
     * @param Response response
     * @return Response
     */
    public function addAllowMethodsHeader(HttpResponse $response, array $methods)
    {
        if (!empty($methods)) {
            $response->setHeader("Access-Control-Allow-Methods", implode($methods, ","));
        }

        return $response;
    }

    /**
     * Add Access-Control-Allow-Origin header to a response object.
     *
     * @param Response response
     * @return Response
     */
    public function addAllowOriginHeader(HttpResponse $response)
    {
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
     * Add Access-Control-Expose-Headers header to a response object. Will
     * only add the header if useCredentials was set to true.
     *
     * @param Response response
     * @return Response
     */
    public function addExposeHeadersHeader(HttpResponse $response)
    {
        if ($this->exposeHeaders && !empty($this->exposedHeaders)) {
            $headers = implode(",", $this->exposedHeaders);
            $response->setHeader("Access-Control-Expose-Headers", $headers);
        }

        return $response;
    }

    /**
     * Add Access-Control-Max-Age header to a response object. Will
     * only add the header if maxAge is not false.
     *
     * @param Response response
     * @return Response
     */
    public function addMaxAgeHeader(HttpResponse $response)
    {
        if ($this->maxAge !== false) {
            $response->setHeader("Access-Control-Max-Age", $this->maxAge);
        }

        return $response;
    }

    public function beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
        if ($this->request->isOptions()) {
            if ($this->request->getHeader("HTTP_ACCESS_CONTROL_REQUEST_METHOD")) {
                // Actual preflight request
                $response = $this->response;

                // TODO: Perform checks:
                // Is the Access-Control-Request-Method header valid?
                // Does Access-Control-Request-Header (HTTP_ACCESS_CONTROL_REQUEST_METHOD)
                // exist. If not just continue, if it exist, is it valid?
                $this->addAllowMethodsHeader(
                    $response,
                    array("DELETE", "GET", "POST", "PUT")
                );
                $this->addAllowHeadersHeader($response);
                $this->addMaxAgeHeader($response);
                $this->addAllowOriginHeader($response);
                $this->addAllowCredentialsHeader($response);

                $response->send();

                return false;
            }
        }
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Set the main CORS headers on all requests.
        $response = $this->response;

        $this->addExposeHeadersHeader($response);
        $this->addAllowOriginHeader($response);
        $this->addAllowCredentialsHeader($response);
    }
}
