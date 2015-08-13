<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:00
 */

namespace controllers;

use helpers\Input;
use helpers\Setting;
use Twig\WpTwigViewHelper;

class ScheduleController extends Controller {


    public function WeekAction(){
        $data = array();
        $data['date'] =  Input::Param('date');
        $data['actionName'] = JIH_CONTROLLER_ACTION_PARAM;
        $data['action'] = 'Week';
        $data['calendars'] = $this->dbContext->Calendars()->Execute();

        if(Input::Param('calendarId')){
            $data['calendar'] = $this->dbContext->Calendars()->FindById(Input::Cookie('calendarId'));
            $data['calendarId'] = Input::Param('calendarId');
        } else {
            $data['calendar'] = $this->dbContext->Calendars()->First();
            $data['calendarId'] = Setting::get('defaultCalendar');
        }

        return  WpTwigViewHelper::getInstance()->Render('day-view.twig',$data);
    }

    public function NewCalendarAction(){
        $data = array();
        return WpTwigViewHelper::getInstance()->Render('new-calendar.twig',$data);
    }

    public function GetHtmlContentType() {
        return 'text/html';
    }

}