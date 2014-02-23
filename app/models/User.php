<?php

namespace Models
{
    class User extends Model
    {

        /**
         * @var integer
         *
         */
        protected $id;

        /**
         * @var string
         *
         */
        protected $username;

        /**
         * @var string
         *
         */
        protected $password;

        /**
         * @var string
         *
         */
        protected $create_time;
    }
}
