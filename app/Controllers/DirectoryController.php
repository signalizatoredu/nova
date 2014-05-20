<?php

namespace Nova\Controllers
{
    use Nova\Object,
        Nova\Models\Directory,
        Nova\Models\DirectoryType;

    class DirectoryController extends ControllerBase
    {
        public function findAllDirectoryTypesAction()
        {
            $data = new Object();
            $data->directory_types = DirectoryType::find()->toArray();

            return $this->jsonResponse($data);
        }

        public function findDirectoryTypeAction($id)
        {
            $id = $this->filter->sanitize($id, array("int"));

            $directoryType = DirectoryType::findFirst($id);

            if (!$directoryType)
                return $this->forward("error/not_found");

            $data = new Object();
            $data->directory_type = $directoryType;

            return $this->jsonResponse($data);
        }

        public function findAllAction()
        {
            $data = new Object();
            $data->directories = Directory::find()->toArray();

            return $this->jsonResponse($data);
        }

        public function findAction($id)
        {
            $id = $this->filter->sanitize($id, array("int"));

            $directory = Directory::findFirst($id);

            if (!$directory)
                return $this->forward("error/not_found");

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

            if (!$directory)
                return $this->forward("error/not_found");

            $directory->delete();
        }
    }
}
