<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:00
 */

namespace controllers;

use Date;
use DbContext;
use Input;
use JihViewHelper;
use Twig\WpTwigViewHelper;

class JihSchedularController extends Controller {



    /**
     *  Constructor
     */
    public function __construct(){
        parent::__construct();
        $helper = JihViewHelper::getInstance();
        $helper->AddCss('css/plugin',"plugin");
        $helper->AddCss('lib/bootstrap-3.2.0/css/bootstrap',"bootstrap");
//
        $helper->AddJs('lib/bootstrap-3.2.0/js/bootstrap','bootstrap');
        $helper->AddJs('lib/jquery-query','jquery-query');
        $helper->AddJs('lib/moment-2.8.3/moment','moment');

        $helper->AddJs('js/util','util');
        $helper->AddJs('js/api','api',array('util'));
        $helper->AddJs('js/schedular','schedular',array('api'));
    }

    public function WeekAction(){
        $data = array();
        $date = new Date(Input::Param('date','now'));
        $startDate = clone $date;
        $dates = array(clone $date);
        while(count($dates)<7){
            $dates[] = clone $date->addDay();
        }
        $data['records'] = $this->dbContext->Events()->Where('datetime >=',$startDate->DbStartOfDay())->Where('datetime <=',$date->DbEndOfDay());
        $data['dates'] = $dates;
        $data['actionName'] = JIH_CONTROLLER_ACTION_PARAM;
        $data['action'] = 'Week';
        $data['calendars'] = $this->dbContext->Calendars()->Execute();
        if(Input::Param('calendarId'))
            $data['calendarId'] = Input::Param('calendarId');
        WpTwigViewHelper::LoadView('day-view.twig',$data);
    }

}