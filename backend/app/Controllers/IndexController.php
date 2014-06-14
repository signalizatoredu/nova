<?php

namespace Nova\Controllers;

class IndexController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function corsAction()
    {
        $response = $this->jsonResponse(null);

        $response->setHeader("Access-Control-Allow-Headers", "Content-Type");
        $response->setHeader("Access-Control-Allow-Methods", "DELETE, GET, POST, PUT");

        return $response;
    }
}
