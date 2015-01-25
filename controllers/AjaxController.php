<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/10/2014
 * Time: 21:49
 */
namespace controllers;

use helpers\Ajax;
use helpers\Date;
use helpers\Input;
use models\Calendar;
use models\Event;
use models\User;

class AjaxController extends Controller {

    /**
     * @param $calendarId
     * @param Date $date should be start of first day: time: 00:00:00
     *
     * @return $this
     */
    public function EventsForWeek($calendarId,$date){
        $date = new Date($date);
        Ajax::Success($this->dbContext->EventViewModels()->Where('calendarId',$calendarId)->Where('datetime >=',$date)->Where('datetime <',$date->CloneAddDays(7))->Execute());
    }

    public function EventById($id){
        Ajax::Success($this->dbContext->EventViewModels()->Where('id',$id)->Execute());
    }

    public function CalendarById($id){
        Ajax::Success($this->dbContext->Calendars()->Where('id',$id)->Execute());
    }

    public function SaveEvent($data){
        if(Input::Get('id')) //Remote to Edit
            $this->EditEvent($data);

        if($this->dbContext->Events()->Where('datetime',$data['datetime'])->Any()){
            Ajax::Error(5,"Already event on this datetime");
        }

        if(User::IsLoggedIn()){
            $user = User::Current();
            $event  = new Event( $data );
            $event->setEmail($user->user_email);
            $event->setName($user->user_login);
            $event->setUserId($user->ID);
            $result = $this->dbContext->Events()->Insert( $event );
            Ajax::Success($result);
        }

        if(isAdministrator() || $this->checkCaptcha($data)) {
            $event  = new Event( $data );
            $result = $this->dbContext->Events()->Insert( $event );
            Ajax::Success($result);
        }
        Ajax::Error(4,"Failed Captcha");
    }

    public function EditEvent($data){
        if(isAdministrator() || $this->checkCaptcha($data)) {
            $event = new Event($this->dbContext->Events()->FindById(Input::Get('id')));
            $event->setAttributes($data);
            $result = $this->dbContext->Events()->UpdateModel($event);
            Ajax::Success($result);
        }
        Ajax::Error(4,"Failed Captcha");
    }

    public function DeleteEvent($id){
        if(isAdministrator()){
            $result = $this->dbContext->Events()->Where('id',$id)->Delete();
            Ajax::Success($result, "Event deleted");
        }

        if (User::IsLoggedIn()){
            $eventUserId = $this->dbContext->Events()->Where('id',$id)->First()->userId;
            if(User::Current()->ID == $eventUserId){
                $result = $this->dbContext->Events()->Where('id',$id)->Delete();
                Ajax::Success($result,"Deleted one of your events");
            } else {
                Ajax::Error(3,"Not your event");
            }
        }
        Ajax::Error(2,"Not logged in");
    }

    public function DeleteEventByPin($id,$pin){
        $event = new Event($this->dbContext->Events()->FindById($id));
        if($event->getId() == 0){
            Ajax::Error(1, "Event does not exist");
        }
        if( !empty($pin) && $event->getPin() == $pin){
            $result = $this->dbContext->Events()->Where('id',$id)->Delete();
            Ajax::Success($result,"Event deleted");
        }
        Ajax::Error(3,"Event pin incorrect");
    }

    public function SaveCalendar($data){
        if(Input::Get('id'))
            $this->EditCalendar($data);
        if(isAdministrator()){
            $calendar = new Calendar($data);
            $result = $this->dbContext->Calendars()->Insert($calendar);
            Ajax::Success($result,"Calendar Created");
        }
        Ajax::Error(1, "No admin rights");
    }

    public function EditCalendar($data){
        if(isAdministrator()){
            $calendar = new Calendar($this->dbContext->Calendars()->FindById(Input::Get('id')));
            if($calendar->getId() == 0)
                Ajax::Error(1, "Calendar does not exist");

            $calendar->setAttributes($data);
            $result = $this->dbContext->Calendars()->UpdateModel($calendar);
            Ajax::Success($result, "Calendar updated");
        }
        Ajax::Error(1, "No admin rights");
    }

    public function DeleteCalendar($id){
        if(isAdministrator()){
            $result = $this->dbContext->Events()->Where('calendarId',$id)->Delete();
            $result += $this->dbContext->Calendars()->Where('id',$id)->Delete();
            Ajax::Success($result);
        }
        Ajax::Error(1, "No admin rights");
    }






    private function checkCaptcha($data){
        $captcha = $data['g-recaptcha-response'];
        $secret = '6Lcw1vsSAAAAAIxl-CW-cIUhxPwO96EZspyzIUJh';
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$remoteIp";
        $response = file_get_contents($url);
        $answers = json_decode($response, true);
        return $answers['success'] == true;
    }
}

