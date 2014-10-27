<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/10/2014
 * Time: 21:49
 */

class AjaxController {

    protected $dbContext;

    public function __construct(){
        $this->dbContext = new DbContext();

    }

    /**
     * @param Date $date should be start of first day: time: 00:00:00
     * @return $this
     */
    public function EventsForWeek(Date $date){
         $this->Json($this->dbContext->Events()->Where('datetime >',$date)->Where('datetime <',$date->CloneAddDays(7))->Execute());
    }

    public function EventById($id){
        $this->Json($this->dbContext->Events()->Where('id',$id)->Execute());
    }

    public function CalendarById($id){
        $this->Json($this->dbContext->Calendars()->Where('id',$id)->Execute());
    }


    private function Json($data,$responseCode = HttpStatusCode::OK){
        echo json_encode($data);
        die($responseCode);
    }
}

class HttpStatusCode extends SplEnum {
    const __default = self::OK;

    const SWITCHING_PROTOCOLS = 101;
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NONAUTHORITATIVE_INFORMATION = 203;
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;
    const PARTIAL_CONTENT = 206;
    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const MOVED_TEMPORARILY = 302;
    const SEE_OTHER = 303;
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 408;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUESTURI_TOO_LARGE = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const IM_A_TEAPOT = 418;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
}