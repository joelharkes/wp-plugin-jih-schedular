<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:00
 */

namespace controllers;

use helpers\Input;
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
        }

        return  WpTwigViewHelper::getInstance()->Render('day-view.twig',$data);
    }

    public function NewCalendarAction(){
        if(Input::IsPost()){
            $data = Input::Post();
            add_filter( 'wp_mail_content_type', array($this,'GetHtmlContentType') );
            $to      = 'denhartoghjohan@gmail.com';
            $subject = 'Aanvraag gebedsruimte';

            $message = WpTwigViewHelper::getInstance()->Render('mail-new-calendar.twig',$data);
            \wp_mail($to, $subject, $message);
            WpTwigViewHelper::getInstance()->Render('new-calendar.twig',array('messageSent'=>true));
        }else {
            $data = array();
            return WpTwigViewHelper::getInstance()->Render('new-calendar.twig',$data);
        }
        return 'mail sent';
    }

    public function GetHtmlContentType() {
        return 'text/html';
    }

}