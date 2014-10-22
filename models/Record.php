<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12-Oct-14
 * Time: 19:06
 */

namespace models;


use Date;
use db\AWPModel;

class Record extends AWPModel {
    public static $_Table = 'jih_schedule_record';

    protected $scheduleId;
    /** @var Date $datetime */
    protected $datetime;
    protected $name;
    protected $email;
    protected $pin;
    protected $description;


    public static function CreateTableQuery()
    {
        return parent::CreateTableQuery("
            scheduleId int NOT NULL,
            datetime datetime NOT NULL,
            name VARCHAR(100) NOT NULL,
            email VARCHAR (100) NULL,
            pin VARCHAR(4) NULL,
            description text  NULL,
            PRIMARY KEY (scheduleId,`datetime`)
		");
    }

    /**
     * @return string
     */
    public function getDatetime()
    {
        if($this->datetime == null)
            $this->setDatetime();
        return $this->datetime->toDb();
    }

    /**
     * @param string $datetime
     */
    public function setDatetime($datetime='')
    {
        $this->datetime = new Date($datetime);
    }

} 