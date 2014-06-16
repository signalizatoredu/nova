<?php

namespace Nova\Controllers;

use Phalcon\Http\Response as HttpResponse;
use Phalcon\Image\Adapter as ImageAdapter;

use Nova\Http\StatusCode as HttpStatusCode;
use Nova\Object;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    /**
     * Check if the client accepts JSON
     *
     * @return boolean
     */
    protected function clientAcceptsJson()
    {
        foreach ($this->request->getAcceptableContent() as $contentType) {
            if ($contentType["accept"] == "application/json") {
                return true;
            }
        }

        return false;
    }

    /**
     * Forward to controller and action
     *
     * @param string $uri Format: controller/action
     * @return void
     */
    protected function forward($uri)
    {
        $uriParts = explode("/", $uri);

        $this->dispatcher->forward(
            array(
                "controller" => $uriParts[0],
                "action" => $uriParts[1]
            )
        );
    }

    protected function getJsonRequest()
    {
        return $this->request->getJsonRawBody();
    }

    protected function imageResponse(ImageAdapter $image)
    {
        $this->view->disable();

        $response = $this->response;
        $response->setContentType($image->getMime());
        $response->setContent($image->render());

        return $response;
    }

    protected function jsonResponse($data, $statusCode = null)
    {
        $this->view->disable();

        $response = $this->response;
        $response->setContentType("application/json", "utf-8");
        $response->setJsonContent($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

        if ($statusCode != null) {
            $response->setStatusCode($statusCode, HttpStatusCode::getMessage($statusCode));
        }

        // Temporary fix, find a better place for this
        $this->cors->setHeaders($response);

        return $response;
    }

    protected function statusCodeResponse($statusCode = HttpStatusCode::OK, $message = null)
    {
        $this->view->disable();

        $response = $this->response;
        $response->setStatusCode($statusCode, HttpStatusCode::getMessage($statusCode));

        if ($message == null) {
            $message = HttpStatusCode::getMessage($statusCode);
        }

        if ($this->request->isAjax() || $this->clientAcceptsJson()) {
            $data = new Object();
            $data->message = $message;
            $response = $this->jsonResponse($data, $statusCode);
        } else {
            $response->setContent($message);
        }

        return $response;
    }
}
