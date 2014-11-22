<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 22-Nov-14
 * Time: 08:53
 */

namespace controllers;

use JihViewHelper;
use models\Calendar;
use Twig\WpTwigViewHelper;

class AdminController extends Controller{

    public function __construct(){
        parent::__construct();

    }

    public static function DoImports(){
        $helper = JihViewHelper::getInstance();
        $helper->AddCss('css/admin',"plugin");
//        $helper->AddJs('lib/jquery-query','jquery-query');

        $helper->AddJs('lib/moment-2.8.3/moment','moment');
        $helper->AddJs('lib/jquery-query','jquery-query');
        $helper->AddJs('js/util','util');
        $helper->AddJs('js/api','api',array('util'));
        $helper->AddJs('js/admin','admin',array('api'));
    }

    public function  CalendarsAction(){

        $data = array();
        $cal = $this->dbContext->Calendars();
        if($search = urldecode(\Input::Get('search'))){
            $cal->WhereLike('name',$search);
        }
        $data['calendars'] = $cal->Execute();
        $data['search'] = $search;
        WpTwigViewHelper::LoadView('admin-schedule.twig',$data);
    }

    public function NewCalendarAction(){
        $data=array();
        WpTwigViewHelper::LoadView('admin-schedule-new.twig',$data);
        WpTwigViewHelper::getInstance()->TryRender();
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