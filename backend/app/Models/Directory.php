<?php

namespace Nova\Models;

class Directory extends ModelBase
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
        $this->hasMany("id", "Nova\Models\Movie", "directory_id", array(
            "alias" => "movie"
        ));
        $this->belongsTo("directory_type_id", "Nova\Models\DirectoryType", "id", array(
            "alias" => "directory_type"
        ));
    }
}
