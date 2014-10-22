<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12-Oct-14
 * Time: 16:33
 */

namespace db;


use db\connections\MysqliConnection;
use db\connections\PdoConnection;
use db\connections\WpConnection;
use ReflectionClass;
use ReflectionProperty;

class QueryBuilder{

    public $preparePlaceholder = '?';

    private $db;
    private $modelName;

    private $select = array("*");
    private $from;
    private $where = array();
    private $whereData = array();
    private $orderBy = array();
    private $limit;

    public function __construct($model){
        $this->modelName = $model;
        $this->from = call_user_func($model .'::GetTable');

        //Switch here between databaseConnections :D
        $this->db = new WpConnection();
        //FOR WORDPRESS DB use %s instead of ?
        $this->preparePlaceholder = '%s';
    }


    public function Where($column,$item=null){
        if(strpos($column,'=')===false && strpos($column,'>')===false && strpos($column,'<')===false && strpos($column,' is')===false){ //preg_match('/^[\w_-\d]+$/',$column)
            $column .= $item===null ? ' is' : ' =';
        }
        if($item == null) $item = 'null';
        $this->where[] = $column;
        $this->whereData[] = $item;
        return $this;
    }

    public function Select($select){
        if(is_array($select)){
            $this->select = $select;
        } else {
            $this->select[] = $select;
        }
        return $this;
    }

    public function OrderBy($column,$order = 'ASC'){
        $this->orderBy[] = $column.' '.$order;
        return $this;
    }

    public function Limit($start,$amount=null){
        $this->limit = $start.($amount==null?'':', '.$amount);
        return $this;
    }

    public function BuildPreparedQuery(){
        return implode(' ',array($this->BuildSelect(),$this->BuildFrom(),$this->BuildWherePrepare(),$this->BuildOrderBy(),$this->BuildLimit()));
    }

    public function BuildQuery(){
        return implode(' ',array($this->BuildSelect(),$this->BuildFrom(),$this->BuildWhere(),$this->BuildOrderBy(),$this->BuildLimit()));
    }

    public function BuildSelect(){
        return 'SELECT '.implode(', ',$this->select);
    }

    public function BuildFrom(){
        return 'FROM '.$this->from;
    }

    public function BuildWhere(){
        $query = $this->BuildWherePrepare();
        foreach ($this->whereData as $value) {
            $query = preg_replace('/'.preg_quote($this->preparePlaceholder).'/', "'".$value."'", $query, 1);
        }

        return $query;
    }

    public function BuildWherePrepare(){
        $placeholder = $this->preparePlaceholder;
        if($this->where == null)
            return '';
        return 'WHERE '.implode(" $placeholder AND ",$this->where)." $placeholder";
    }

    public function BuildOrderBy(){
        if($this->orderBy == null)
            return '';
        return 'ORDER BY '.implode(', ',$this->orderBy);
    }

    public function BuildLimit(){
        if($this->limit==null)
            return '';
        return 'LIMIT '.$this->limit;

    }

    public function Execute(){
        return $this->db->ExecutePrepared($this->BuildPreparedQuery(),$this->whereData);
    }

    public function ToList(){
        return $this->Execute();
    }

    public function First(){
        $this->limit(1);
        return $this->Execute();

    }

    public function Insert(AModel $model){
        $placeholder = $this->preparePlaceholder;
        $data = $model->getDbProperties();
        $table = $model::GetTable();
        $columns = implode(', ',array_keys($data));
        $values = array_values($data);
        $valueSql = substr(str_repeat("$placeholder, ",count($data)),0,-2);
        return $this->db->CommandPrepared("INSERT INTO $table ($columns) VALUES ($valueSql)",$values);
    }

    public function Update(AModel $model){
        $placeholder = $this->preparePlaceholder;
        $data = $model->getDbProperties();
        $table = $model::GetTable();
        $columns = implode("= $placeholder, ",array_keys($data)).'= '.$placeholder;
        $values = array_values($data);
        return $this->db->CommandPrepared("UPDATE $table SET $columns ".$this->BuildWhere().$this->BuildOrderBy().$this->BuildLimit(),$values);
    }

    //Now getDbProperties from AModel is used
    public function GetModelProperties(AModel $model){
        $dbVars = array();
        $ref = new ReflectionClass($model);
        $props = $ref->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach($props as $property){
            $name = $property->getName();
            if(strpos($name, '_') !== 0 && !in_array($name,$model::$_AutoIncrement))
                $dbVars[$name] = $model->{'get'.ucfirst($name)}();
        }
        return $dbVars;
    }
}