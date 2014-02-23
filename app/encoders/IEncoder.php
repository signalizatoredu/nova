<?php

namespace Encoders
{
    interface IEncoder
    {
        public function encode($data);
        public function decode($data);
    }
}
