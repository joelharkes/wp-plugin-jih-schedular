<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:00
 */

class JihSchedularController {

    protected $dbContext;

    /**
     *  Constructor
     */
    public function __construct(){
        $helper = JihViewHelper::getInstance();
        $helper->AddCss('plugin');
        $helper->AddCss('bootstrap');
        $helper->AddJs('jquery-query');
        $helper->AddJs('moment');
        $helper->AddJs('bootstrap');
        $helper->AddJs('schedular');

        $this->dbContext = new DbContext();
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

    public function WeekAction(){
        $data = array();
        $date = new Date(Input::Param('date','now'));
        $startDate = clone $date;
        $dates = array(clone $date);
        while(count($dates)<7){
            $dates[] = clone $date->addDay();
        }
        $data['records'] = $this->dbContext->Records()->Where('datetime >=',$startDate->DbStartOfDay())->Where('datetime <=',$date->DbEndOfDay());
        $data['dates'] = $dates;
        $data['actionName'] = JIH_CONTROLLER_ACTION_PARAM;
        $data['action'] = 'Week';
        Twig\WpTwigViewHelper::LoadView('day-view.twig',$data);
    }

    public function SavePrayerHourAction(){
        global $wpdb;
        $recordTable = $wpdb->prefix . 'jih_schedule_record';

        $model = new \models\Record($_POST);
//        die(var_dump($model));
        $this->dbContext->Records()->Insert($model);
//
        $date = new Date(Input::Param('datetime'));
        $_POST['date'] = $date;

        if($url = Input::Post('redirectUrl')){
            header('location: '.$url,true,302); exit;
        }


    }


} 