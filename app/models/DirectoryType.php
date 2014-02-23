<?php

namespace Models
{
    class DirectoryType extends Model
    {

        /**
         * @var integer
         *
         */
        public $id;

        /**
         * @var string
         *
         */
        public $type;


        /**
         * Initializer method for model.
         */
        public function initialize()
        {
            $this->hasMany("id", "Models\Directory", "directory_type_id", array(
                "alias" => "directory"
            ));
        }

    }
}
