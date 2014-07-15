<?php

namespace Nova\Controllers;

use Nova\Object;
use Nova\Models\DirectoryType;

class DirectoryTypeController extends ControllerBase
{
    public function indexAction()
    {
        $data = new Object();
        $data->directory_types = DirectoryType::find()->toArray();

        return $this->jsonResponse($data);
    }

    public function findAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $directoryType = DirectoryType::findFirst($id);

        if (!$directoryType) {
            return $this->forward("error/notFound");
        }

        $data = new Object();
        $data->directory_type = $directoryType;

        return $this->jsonResponse($data);
    }
}
