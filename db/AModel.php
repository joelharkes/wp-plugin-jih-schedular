<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12-Oct-14
 * Time: 16:50
 */

namespace db;


use Exception;
use ReflectionClass;
use ReflectionProperty;

abstract class AModel {

    public static $_Table;
    public static $_AutoIncrement=array();

    public function __construct(array $data){
        $this->setAttributesSafe($data);
    }

    public static function CreateTableQuery($columnSql){
        return 'CREATE TABLE IF NOT EXISTS ' . static::GetTable() . " ( $columnSql )";
    }

    public static function GetTable(){
        return static::$_Table;
    }


    /**
     * @return array of object variables not starting with an _ or in static::$_AutoIncrement
     */
    public function getDbProperties(){
        $dbVars = array();
        $ref = new ReflectionClass($this);
        $props = $ref->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach($props as $property){
            $name = $property->getName();
            if(strpos($name, '_') !== 0 && !in_array($name,static::$_AutoIncrement))
                $dbVars[$name] = $this->{'get'.ucfirst($name)}();
        }
        return $dbVars;
    }

    public function setAttributes(array $data){
        foreach ($data as $attribute => $value) {
            $this->setAttribute($attribute,$value);
        }
    }
    public function setAttribute($attribute,$value){
        $this->{'set'.ucfirst($attribute)}($value);
    }

    public function setAttributesSafe(array $data){
        foreach ($data as $attribute => $value) {
            if(property_exists($this,$attribute))
                $this->{'set'.ucfirst($attribute)}($value);
        }
    }

    //Catch unimplemented set and get functions
    public function __call($name,$args){
        if(substr($name,0,3) == 'set' && count($args)>0){
            if ($this->propExists($propName = lcfirst(substr($name,3))))
                $this->$propName = $args[0];
            return true;
        }
        if(substr($name,0,3) == 'get'){
            if ($this->propExists($propName = lcfirst(substr($name,3))))
                return $this->$propName;
        }
    }

    private function propExists($name){
        if(property_exists($this,$name)){
            return true;
        }
        $class = get_class($this);
        throw new Exception("Property $name does not exists in $class");
    }

    public function __set($name, $value)
    {
        $this->{'set'.ucfirst($name)}($value[0]);
    }

    public function __get($name){
        $this->{'get'.ucfirst($name)}();
    }

    public static function ClassName(){
        return get_called_class();
    }
} 