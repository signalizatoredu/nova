<?php

namespace Models
{
    class Directory extends Model
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
        public $path;

        /**
         * @var integer
         *
         */
        public $directory_type_id;


        /**
         * Initializer method for model.
         */
        public function initialize()
        {
            $this->hasMany("id", "Models\Movie", "directory_id", array(
                "alias" => "movie"
            ));
            $this->belongsTo("directory_type_id", "Models\DirectoryType", "id", array(
                "alias" => "directory_type"
            ));
        }

    }
}
