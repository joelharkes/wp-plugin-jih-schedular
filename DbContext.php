<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12-Oct-14
 * Time: 13:46
 */

class DbContext {


    public function Schedules(){
        return new \db\QueryBuilder(\models\Schedule::ClassName());
    }

    public function Records(){
        return new \db\QueryBuilder(\models\Record::ClassName());
    }

    /**
     * @param string $name class name of model
     * @return \db\QueryBuilder querybuilder for module
     */
    public function __call($name,$args){
        if ($this->endsWith($name,'s'))
            $name = substr($name,0,-1);
        return new \db\QueryBuilder('\\models\\'.$name);
    }

    private function endsWith($haystack, $needle) {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

}








