<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 14:32
 */

class Date extends DateTime{

    public function __toString(){
        return $this->format('Y-m-d');
    }

    public function toDb(){
        return $this->format("Y-m-d H:i:s");
    }

    public function addDay($days=1){
        if($days<0)
            return $this->sub(new DateInterval('P'.($days*-1).'D'));
        return $this->add(new DateInterval('P'.$days.'D'));
    }

    public function CloneAddDays($days=1){
        $clone = clone $this;
        return $clone->addDay($days);
    }

} 