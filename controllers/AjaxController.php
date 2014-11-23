<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/10/2014
 * Time: 21:49
 */
namespace controllers;


use Date;
use HttpStatusCode;
use models\Calendar;
use models\Event;

class AjaxController extends Controller {


    /**
     * @param $calendarId
     * @param Date $date should be start of first day: time: 00:00:00
     *
     * @return $this
     */
    public function EventsForWeek($calendarId,$date){
        $date = new Date($date);
        $this->Json($this->dbContext->Events()->Where('calendarId',$calendarId)->Where('datetime >',$date)->Where('datetime <',$date->CloneAddDays(7))->Execute());
    }

    public function EventById($id){
        $this->Json($this->dbContext->Events()->Where('id',$id)->Execute());
    }

    public function CalendarById($id){
        $this->Json($this->dbContext->Calendars()->Where('id',$id)->Execute());
    }

    public function SaveEvent($data){
        if(\Input::Get('id'))
            $this->EditEvent($data);
        $event = new Event($data);
        $result = $this->dbContext->Events()->Insert($event);
        $this->JsonResult($result);
    }

    public function EditEvent($data){
        $event = new Event($this->dbContext->Events()->FindById(\Input::Get('id')));
        $event->setAttributes($data);
        $result = $this->dbContext->Events()->UpdateModel($event);
        $this->JsonResult($result);
    }

    public function DeleteEvent($id){
        if(isAdministrator()){
            $result = $this->dbContext->Events()->Where('id',$id)->Delete();
            $this->JsonResult($result);
        }
        $this->JsonResult(false);
    }

    public function SaveCalendar($data){
        if(\Input::Get('id'))
            $this->EditCalendar($data);
        if(isAdministrator()){
            $calendar = new Calendar($data);
            $result = $this->dbContext->Calendars()->Insert($calendar);
            $this->JsonResult($result,"Calendar Created");
        }
        $this->JsonResult(false);
    }

    public function EditCalendar($data){
        if(isAdministrator()){
            $calendar = new Calendar($this->dbContext->Calendars()->FindById(\Input::Get('id')));
            $calendar->setAttributes($data);
            $result = $this->dbContext->Calendars()->UpdateModel($calendar);
            $this->JsonResult($result);
        }
        $this->JsonResult(false);
    }

    public function DeleteCalendar($id){
        if(isAdministrator()){
            $result = $this->dbContext->Events()->Where('calendarId',$id)->Delete();
            $result += $this->dbContext->Calendars()->Where('id',$id)->Delete();
            $this->JsonResult($result);
        }
        $this->JsonResult(false);
    }

    private function JsonResult($result,$errorMessage="Request was not allowed :S"){
        $this->Json($errorMessage,$result ? HttpStatusCode::OK : HttpStatusCode::FORBIDDEN);
    }

    private function Json($data,$responseCode = HttpStatusCode::OK){
        http_response_code($responseCode);
        echo json_encode($data);
        die();
    }
}

