<?php

namespace Controllers
{
    use Models\Directory,
        Models\DirectoryType;

    class DirectoryController extends ControllerBase
    {

        public function findAllDirectoryTypesAction()
        {
            $models = array();

            foreach (DirectoryType::find() as $type) {
                $models[] = $type;
            }

            $data = new \stdClass();
            $data->directory_types = $models;


            return $this->jsonResponse($data);
        }

        public function findDirectoryTypeAction($id)
        {
            $id = $this->filter->sanitize($id, array("int"));

            $directoryType = DirectoryType::findFirst($id);

            if (!$directoryType)
                return $this->notFoundResponse();

            $data = new \stdClass();
            $data->directory_type = $directoryType;

            return $this->jsonResponse($data);
        }

        public function findAllAction()
        {
            $models = array();

            foreach (Directory::find() as $directory) {
                $models[] = $directory;
            }

            $data = new \stdClass();
            $data->directories = $models;

            return $this->jsonResponse($data);
        }

        public function findAction($id)
        {
            $id = $this->filter->sanitize($id, array("int"));

            $directory = Directory::findFirst($id);

            if (!$directory)
                return $this->notFoundResponse();

            $data = new \stdClass();
            $data->directory = $models;

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
            return $this->notFoundResponse();
        }

        public function deleteAction($id)
        {
            $id = $this->filter->sanitize($id, array("int"));

            $directory = Directory::findFirst($id);

            if (!$directory)
                return $this->notFoundResponse();

            $directory->delete();
        }
    }
}