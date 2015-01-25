<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:00
 */

namespace controllers;

use helpers\Input;
use helpers\ViewHelper;
use Twig\WpTwigViewHelper;

class ScheduleController extends Controller {

    /**
     *  Constructor
     */
    public function __construct(){
        parent::__construct();
        $helper = ViewHelper::getInstance();
        $helper->AddCss('css/plugin',"plugin");
        $helper->AddCss('lib/bootstrap-3.2.0/css/bootstrap',"bootstrap");
//
        $helper->AddJs('lib/bootstrap-3.2.0/js/bootstrap','bootstrap');
        $helper->AddJs('lib/jquery-query','jquery-query');
        $helper->AddJs('lib/moment-2.8.3/moment-with-locales','moment');
        $helper->AddJs('lib/jquery.cookie','cookie');

        $helper->AddJs('js/util','util');
        $helper->AddJs('js/api','api',array('util'));
        $helper->AddJs('js/schedular','schedular',array('api'));
        $helper->AddJsUrl('https://www.google.com/recaptcha/api.js','google-api',array());
    }

    public function WeekAction(){
        $data = array();

        $data['actionName'] = JIH_CONTROLLER_ACTION_PARAM;
        $data['action'] = 'Week';
        $data['calendars'] = $this->dbContext->Calendars()->Execute();

        if(Input::Param('calendarId')){
            $data['calendar'] = $this->dbContext->Calendars()->FindById(Input::Cookie('calendarId'));
            $data['calendarId'] = Input::Param('calendarId');
        } else {
            $data['calendar'] = $this->dbContext->Calendars()->First();
        }

        WpTwigViewHelper::LoadView('day-view.twig',$data);
    }

}