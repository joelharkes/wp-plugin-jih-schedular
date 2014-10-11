<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 13:01
 */

class Input {

    public static function Post($item,$default=null){
        return  isset($_POST[$item]) ? $_POST[$item] : $default;
    }

    public static function Get($item,$default=null){
        return  isset($_GET[$item]) ? $_GET[$item] : $default;
    }

    public static function Cookie($item,$default=null){
        return  isset($_COOKIE[$item]) ? $_COOKIE[$item] : $default;
    }

    public static function Param($item,$default=null){
        return self::Post($item) ?: self::Get($item) ?: self::Cookie($item) ?: $default;
    }

}