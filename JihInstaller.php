<?php
use db\connections\WpConnection;

/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 16:03
 */

class JihInstaller {


    public static function Install(){
        global $jih_version;

//        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $db = new WpConnection();
        $db->Execute(\models\Calendar::CreateTableQuery());
        $db->Execute(\models\Event::CreateTableQuery());
        delete_option( 'jih_schedular_version' );
        add_option( 'jih_schedular_version', $jih_version );
    }


    public static function InstallTestDate() {
        $db = new DbContext();
        $cal = new \models\Calendar();
        $cal->setName("Test Calendar");
        $db->Calendars()->Insert($cal);
    }

} 