<?php
/**
 * Created by PhpStorm.
 * User: nor02
 * Date: 17/08/2018
 * Time: 11:34
 */

class Hash
{
    public static function make($string,$salt='') {
        return hash('sha256',$string.$salt);
    }

    public static function salt($length) {
        return utf8_encode(random_bytes($length));
    }

    public static function unique() {
        return self::make(uniqid());
    }
}