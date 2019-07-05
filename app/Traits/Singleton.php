<?php

namespace Ayctor\Traits;

trait Singleton
{
    private static $_instance = null;

    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance = new static;
        }

        return self::$_instance;
    }
}
