<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:00
 */

class JihSchedularController {

    /**
     *  Constructor
     */
    public function __construct(){
        $helper = JihViewHelper::getInstance();
        $helper->AddCss('plugin');
        $helper->AddCss('bootstrap');
        $helper->AddJs('bootstrap');
        $helper->AddJs('schedular');
    }

    public function route($action){
        $actionMethod = $action.'Action';
        if(method_exists($this,$actionMethod))
            $this->$actionMethod();
        else
            throw new Exception("Method $actionMethod was not yest implemented in JihSchedularController");

    }


    public function WeekViewAction(){
        $startDate = new Date(Input::Param('date','now'));

        return JihViewHelper::getInstance()->LoadView('jih-dayview',array('startDate'=>$startDate));
    }

    public function SavePrayerHourAction(){
        global $wpdb;
        $recordTable = $wpdb->prefix . 'jih_schedule_record';

        $date = new Date(Input::Param('datetime'));
        $wpdb->insert(
            $recordTable,
            array(
                'scheduleId' => Input::Param('scheduleId',1),
                'datetime' => $date->format("Y-m-d H:00:00"),
                'name' => Input::Param('name'),
                'email' => Input::Param('email'),
                'pin' => Input::Param('pin'),
                'description' => Input::Param('description')
            )
        );

        $_POST['date'] = $date;
        $this->WeekViewAction();
    }


} 