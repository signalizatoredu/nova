<?php

namespace Nova\Controllers;

class ControllerBase extends \Phalcon\Mvc\Controller
{
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

    protected function imageResponse(\Phalcon\Image\Adapter $image)
    {
        $this->view->disable();

        $response = new \Phalcon\Http\Response();
        $response->setContentType($image->getMime());
        $response->setContent($image->render());

        return $response;
    }

    protected function jsonResponse($data)
    {
        $this->view->disable();

        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json", "utf-8");
        $response->setJsonContent($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

        return $response;
    }
}
