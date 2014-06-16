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

        $this->setOptionsHeaders();

        return $response;
    }
}
