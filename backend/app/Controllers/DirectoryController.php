<?php

namespace Nova\Controllers;

use Nova\Object;
use Nova\Models\Directory;

class DirectoryController extends ControllerBase
{
    public function indexAction()
    {
        $data = new Object();
        $data->directories = Directory::find()->toArray();

        return $this->jsonResponse($data);
    }

    public function findAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $directory = Directory::findFirst($id);

        if (!$directory) {
            return $this->forward("error/not_found");
        }

        $data = new Object();
        $data->directory = $directory;

        return $this->jsonResponse($data);
    }

    public function createAction()
    {
        $data = $this->getJsonRequest();

        $directory = new Directory();
        $directory->path = $data->directory->path;
        $directory->directory_type_id = $data->directory->directory_type_id;
        $directory->save();

        $data->directory = $directory;

        return $this->jsonResponse($data);
    }

    public function saveAction($id)
    {
        return $this->forward("error/not_found");
    }

    public function deleteAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $directory = Directory::findFirst($id);

        if (!$directory) {
            return $this->forward("error/not_found");
        }

        $directory->delete();

        return $this->jsonResponse();
    }
}
