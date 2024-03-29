<?php

namespace Nova\Encoders;

interface IEncoder
{
    /**
     * Encode data according to the encoder rules
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function encode($data);

    /**
     * Decode data according to the encoder rules
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function decode($data);
}
