<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 16:03
 */

class JihInstaller {


    public static function Install(){
        global $wpdb;
        global $jih_version;

        $scheduleTable = $wpdb->prefix . 'jih_schedule';
        $recordTable = $wpdb->prefix . 'jih_schedule_record';
        /*
         * We'll set the default character set and collation for this table.
         * If we don't do this, some characters could end up being converted
         * to just ?'s when saved in our table.
         */
        $charset_collate = '';

        if ( ! empty( $wpdb->charset ) ) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }

        if ( ! empty( $wpdb->collate ) ) {
            $charset_collate .= " COLLATE {$wpdb->collate}";
        }

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta("CREATE TABLE IF NOT EXISTS $scheduleTable (
		id int NOT NULL AUTO_INCREMENT,
		name VARCHAR(100) DEFAULT 'No Name' NOT NULL,
		description text NOT NULL,
		PRIMARY KEY id (id)
	    ) $charset_collate;");

        dbDelta("CREATE TABLE IF NOT EXISTS $recordTable (
		scheduleId int NOT NULL,
		`datetime` datetime NOT NULL,
		name VARCHAR(100) NOT NULL,
		email VARCHAR (100) NULL,
		pin VARCHAR(4) NULL,
		description text  NULL,
		PRIMARY KEY (scheduleId,`datetime`)
	    ) $charset_collate;");

        add_option( 'jih_schedular_version', $jih_version );
    }


    public static function InstallTestDate() {
        global $wpdb;
        $scheduleTable = $wpdb->prefix . 'jih_schedule';
        $recordTable = $wpdb->prefix . 'jih_schedule_record';

        $wpdb->insert(
            $scheduleTable,
            array(
                'name' => 'test name',
                'description' => 'this is an html description',
            )
        );

        $wpdb->insert(
            $recordTable,
            array(
                'scheduleId' => 1,
                'datetime' => date("Y-m-d H:i:s"),
                'name' => 'Me Mario',
                'email' => 'test@test.nl',
                'pin' => '1234',
                'description' => 'This is a description.'
            )
        );


    }

} 