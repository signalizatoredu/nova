<?php

namespace Nova\Models;

class AuthToken extends Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $series;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @var string
     */
    protected $expiration_date;

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field series
     *
     * @param string $series
     * @return $this
     */
    public function setSeries($series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Method to set the value of field expirary_date
     *
     * @param string $expirary_date
     * @return $this
     */
    public function setExpirationDate($expiration_date)
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field series
     *
     * @return string
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Returns the value of field token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Returns the value of field expirary_date
     *
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            "id" => "id",
            "series" => "series",
            "token" => "token",
            "expiration_date" => "expiration_date",
            "user_id" => "user_id"
        );
    }

    public function initialize()
    {
        $this->belongsTo("user_id", "Nova\Models\User", "id", array(
            "alias" => "User"
        ));
    }

    /**
     * Generate a UUID as taken from http://stackoverflow.com/a/18206984
     *
     * @return string
     */
    public static function generateUuid()
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}
