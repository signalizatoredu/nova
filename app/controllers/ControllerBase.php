<?php

namespace Controllers
{
    class ControllerBase extends \Phalcon\Mvc\Controller
    {
        protected function forward($url)
        {
            $uriParts = explode("/", $uri);

            return $this->dispatcher->forward(
                array(
                    "controller" => $uriParts[0],
                    "action" => $uriParts[1]
                )
            );
        }

        protected function getJsonRequest()
        {
            $data = $this->request->getRawBody();
            return json_decode($data);
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
            $response->setContentType("application/json", "UTF-8");
            $response->setContent(json_encode($data, JSON_PRETTY_PRINT));

            return $response;

        }

        protected function notFoundResponse()
        {
            $response = new \Phalcon\Http\Response();
            $response->setStatusCode(404, "Not Found");
            $response->setContent("Sorry, the page doesn't exist.");

            return $response;
        }
    }
}
