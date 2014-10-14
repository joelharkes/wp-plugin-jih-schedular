<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12-Oct-14
 * Time: 13:43
 */

namespace models;

use db\AWPModel;

class Schedule extends AWPModel {

    public static $_Table = 'jih_schedule';
    public static $_AutoIncrement=array('id');

    public $id;
    public $name;
    public $description;


    public static function CreateTableQuery(){
        return parent::CreateTableQuery("
            id int NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) DEFAULT 'No Name' NOT NULL,
            description text NOT NULL,
            PRIMARY KEY id (id)'
		");
    }
}
