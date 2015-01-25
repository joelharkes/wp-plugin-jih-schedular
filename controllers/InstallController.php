<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 25-Jan-15
 * Time: 15:08
 */

namespace controllers;


use helpers\Ajax;
use models\Event;
use models\User;

class InstallController extends  Controller {
    public function InstallAction(){
        global $jih_version;

        $db = new \db\connections\WpConnection();

        $db->Execute(\models\Calendar::CreateTableQuery());
        $db->Execute(\models\Event::CreateTableQuery());

        //View always drop views first
        $table = \models\EventViewModel::GetPrefixedTable();
        $db->Execute("DROP VIEW IF EXISTS $table;");
        $db->Execute(\models\EventViewModel::CreateTableQuery());

        delete_option( 'jih_schedular_version' );
        add_option( 'jih_schedular_version', $jih_version );
        Ajax::Success('success','CreateTable commands successful');
    }

    public function InstallTestDataAction() {
        $db = $this->dbContext;
        $cal = new \models\Calendar();
        $cal->setName("Example Calendar");
        $db->Calendars()->Insert($cal);

        $event = new Event();
        $event->setName("Example");
        $event->setCalendarId(1);
        $event->setDatetime("tomorrow");

        if(User::IsLoggedIn()){
            $user = User::Current();
            $event->setEmail($user->user_email);
            $event->setName($user->user_login);
            $event->setUserId($user->ID);
            $this->dbContext->Events()->Insert( $event );
        }
        Ajax::Success('Success','Insert dummy data completed');
    }

    public static function DropEverythingAction(){
        $db = new \db\connections\WpConnection();
        foreach(array(\models\Calendar::GetPrefixedTable(),\models\Event::GetPrefixedTable()) as $table){
            $db->Execute("DROP TABLE IF EXISTS $table;");
        }
        foreach(array(\models\EventViewModel::GetPrefixedTable()) as $table){
            $db->Execute("DROP VIEW IF EXISTS $table;");
        }
    }
}