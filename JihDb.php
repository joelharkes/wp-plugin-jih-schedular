<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 17:22
 */


class JihDb {

    public static function getRecord($scheduleId=1,$datetime){
        $scheduleId = (int)$scheduleId;
        $datetime = new Date($datetime);
        $datetime = $datetime->toDb();
        global $wpdb;
        return $wpdb->get_results("select * from wp_jih_schedule_record WHERE scheduleId = $scheduleId AND `datetime` = '$datetime'");
    }

    public static function getRecordByHour($schedule=1,$date,$hour){
        if (strlen($hour)<=1)
            $hour="0".$hour;
        $date = new Date($date);
        $date = $date->format("Y-m-d $hour:00:00");
        return self::getRecord($schedule,$date);
    }

    public static function getNameByHour($scheduleId=1,$date,$hour){
        if (strlen($hour)<=1)
            $hour="0".$hour;
        $date = new Date($date);
        $date = $date->format("Y-m-d $hour:00:00");
        global $wpdb;
        return  $wpdb->get_var("select name from wp_jih_schedule_record WHERE scheduleId = $scheduleId AND `datetime` = '$date'",0,0);
    }
} 