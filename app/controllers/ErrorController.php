<?php

namespace Controllers
{
    class ErrorController extends ControllerBase
    {
        protected function notFoundResponse($code, $statusMessage, $errorMessage)
        {
            $this->view->disable();

            $response = new \Phalcon\Http\Response();
            $response->setStatusCode($code, $statusMessage);

            if ($this->request->isAjax()) {
                $error = new \stdClass();
                $error->error = $errorMessage;

                $response->setContent(json_encode($error, JSON_PRETTY_PRINT));
            } else {
                $response->setContent($errorMessage);
            }


            return $response;
        }

        public function notFoundAction()
        {
            return $this->notFoundResponse(404, "Not Found", "Sorry, the page doesn't exist.");
        }
    }
}
