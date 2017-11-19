<?php

namespace App\Utils;

class UuidGenerator
{
    public static function generate()
    {
        return md5(uniqid(rand() . microtime(), true));
    }
}