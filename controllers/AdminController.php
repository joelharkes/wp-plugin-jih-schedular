<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 22-Nov-14
 * Time: 08:53
 */

namespace controllers;

use helpers\Input;
use helpers\ViewHelper;
use Twig\WpTwigViewHelper;

class AdminController extends Controller{

    public function __construct(){
        parent::__construct();

    }

    public static function DoImports(){
        $helper = ViewHelper::getInstance();
        $helper->AddCss('css/admin',"jih-plugin");
        $helper->AddCss('lib/datetime-picker/jquery.datetimepicker',"jquery-datetime-picker");
//        $helper->AddJs('lib/jquery-query','jquery-query');

        $helper->AddJs('lib/moment-2.8.3/moment','moment');
        $helper->AddJs('lib/jquery-query','jquery-query');
        $helper->AddJs('lib/datetime-picker/jquery.datetimepicker','jquery-datetime-picker');
        $helper->AddJs('js/util','util');
        $helper->AddJs('js/api','api',array('util'));
        $helper->AddJs('js/admin','admin',array('api'));


    }

    public function  CalendarsAction(){
        $data = array();
        $cal = $this->dbContext->Calendars();
        if($search = urldecode(Input::Get('search'))){
            $cal->WhereLike('name',$search);
        }
        $data['calendars'] = $cal->Execute();
        $data['search'] = $search;
        WpTwigViewHelper::LoadView('admin-schedule.twig',$data);
    }

    public function CalendarFormAction(){
        $data=array();
        if($id = Input::Param('id'))
            $data['calendar'] = $this->dbContext->Calendars()->Where('id',$id)->Execute()->First();
        WpTwigViewHelper::LoadView('admin-calendar-form.twig',$data);
    }

    public function  EventsAction(){

        $data = array();
        $cal = $this->dbContext->Events();
        if($search = urldecode(Input::Get('search'))){
            $cal->WhereLike('name',$search);
        }
        $data['events'] = $cal->Execute();
        $data['search'] = $search;
        WpTwigViewHelper::LoadView('admin-event-overview.twig',$data);
    }

    public function EventFormAction(){
        $data=array();
        $data['calendars'] = $this->dbContext->Calendars()->Execute()->First();
        if($id = Input::Param('id'))
            $data['event'] = $this->dbContext->Events()->Where('id',$id)->Execute();
        WpTwigViewHelper::LoadView('admin-event-form.twig',$data);
    }



//    protected function saveCalendar($data){
//        $calendar = new Calendar($data);
//        return $this->dbContext->Calendars()->Insert($calendar);
//    }

//    protected function  GotoPage($action){
//        header('Location: '.$_SERVER['PHP_SELF'].'?page=jih-'.$action);
//        die;
//    }

}