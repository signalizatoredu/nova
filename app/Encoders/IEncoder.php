<?php

namespace Nova\Encoders
{
    interface IEncoder
    {
        public function encode($data);
        public function decode($data);
    }
}