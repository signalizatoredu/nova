<?php

namespace Nova\Controllers;

use Nova\Http\StatusCode as HttpStatusCode;
use Nova\Object;

class ErrorController extends ControllerBase
{
    public function notFoundAction()
    {
        $message = "404, the requested URL "
                 . $this->router->getRewriteUri()
                 . " was not found on this server.";

        return $this->statusCodeResponse(
            HttpStatusCode::NOT_FOUND,
            $message
        );
    }

    public function forbiddenAction()
    {
        $message = "Forbidden. You don't have permissions to access "
                 . $this->router->getRewriteUri()
                 . " on this server.";

        return $this->statusCodeResponse(
            HttpStatusCode::FORBIDDEN,
            $message
        );
    }

    public function unauthorizedAction()
    {
        $message = "Unauthorized. You don't have sufficient permissions to access "
                 . $this->router->getRewriteUri()
                 . " on this server.";

        return $this->statusCodeResponse(
            HttpStatusCode::UNAUTHORIZED,
            $message
        );
    }
}
