<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 19-Oct-14
 * Time: 08:12
 */

//TODO Build
class Logger extends Singleton {



    public static function Log($text,$level='Info'){
        die(var_dump($text));
    }

    public function LogRow($text,$level){

    }
}