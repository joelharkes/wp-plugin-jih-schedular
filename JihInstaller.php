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

        //View always drop views first
        $table = models\EventViewModel::GetPrefixedTable();
        $db->Execute("DROP VIEW IF EXISTS $table;");
        $db->Execute(\models\EventViewModel::CreateTableQuery());

        delete_option( 'jih_schedular_version' );
        add_option( 'jih_schedular_version', $jih_version );
    }

    public static function InstallTestDate() {
        $db = new DbContext();
        $cal = new \models\Calendar();
        $cal->setName("Test Calendar");
        $db->Calendars()->Insert($cal);
    }

    public static function DropEverything(){
        $db = new WpConnection();
        foreach(array(\models\Calendar::GetPrefixedTable(),\models\Event::GetPrefixedTable()) as $table){
            $db->Execute("DROP TABLE IF EXISTS $table;");
        }
        foreach(array(\models\EventViewModel::GetPrefixedTable()) as $table){
            $db->Execute("DROP VIEW IF EXISTS $table;");
        }
    }

} 