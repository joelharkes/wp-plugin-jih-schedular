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

class Event extends AWPModel {
    public static $_Table = 'jih_event';
    public static $_PrimaryKey='id';

    protected $id;
    protected $calendarId;
    /** @var Date $datetime */
    protected $datetime;
    protected $name;
    protected $email;
    protected $pin;
    protected $description;


    public static function CreateTableQuery()
    {
        return parent::CreateTableQuery("
            id int NOT NULL AUTO_INCREMENT,
            calendarId int NOT NULL,
            datetime datetime NOT NULL,
            name VARCHAR(100) NOT NULL,
            email VARCHAR (100) NULL,
            pin VARCHAR(4) NULL,
            description text  NULL,
            PRIMARY KEY (id),
            UNIQUE KEY `calendar_date` (`calendarId`,`datetime`)
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

    //GENERATED
    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId( $id ) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCalendarId() {
        return $this->calendarId;
    }

    /**
     * @param mixed $calendarId
     */
    public function setCalendarId( $calendarId ) {
        $this->calendarId = $calendarId;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( $name ) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail( $email ) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPin() {
        return $this->pin;
    }

    /**
     * @param mixed $pin
     */
    public function setPin( $pin ) {
        $this->pin = $pin;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription( $description ) {
        $this->description = $description;
    }




} 