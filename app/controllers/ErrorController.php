<?php

namespace Controllers
{
    class ErrorController extends ControllerBase
    {
        public function notFoundAction()
        {
            return $this->notFoundResponse();
        }
    }
}
