<?php

namespace Nova\Models;

class DirectoryType extends ModelBase
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
        $this->hasMany("id", "Nova\Models\Directory", "directory_type_id", array(
            "alias" => "directory"
        ));
    }
}
