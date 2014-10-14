<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12-Oct-14
 * Time: 16:31
 */

namespace db;


use mysqli_result;
use mysqli_stmt;

class Connection{
    protected $mysqli;

    public function __construct($mysqli=null){
        if($mysqli!=null){
            $this->mysqli = $mysqli;
        } else {
            global $wpdb;
            if(method_exists($wpdb,'getDbConnection')){
                $this->mysqli = $wpdb->getDbConnection();
            } else {
                $this->mysqli = mysqli_init();
                mysqli_real_connect( $this->mysqli, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            }
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed|mysqli_stmt|mysqli_result
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->mysqli,$name),$arguments);
    }

    /**
     * @param string $sql
     * @param array $values
     * @param int $resultType
     * @return array
     */
    public function ExecutePrepared($sql,$values,$resultType = MYSQLI_ASSOC){
        $stmt = $this->prepare($sql,$values);
        $stmt->execute();
        return new ResultSet($stmt->get_result()->fetch_all($resultType));
    }

    /**
     * @param string $sql
     * @param int $resultType
     * @return array
     */
    public function Execute($sql,$resultType = MYSQLI_ASSOC){
        return new ResultSet($this->mysqli->query($sql)->fetch_all($resultType));
    }

    public function Command($sql){
        return $this->mysqli->query($sql);
    }

    public function CommandPrepare($sql,$values){
        return $this->prepare($sql,$values)->execute();
    }

    private function prepare($sql,$values){
        $stmt = $this->mysqli->prepare($sql);
        foreach ($values as $value) {
            $stmt->bind_param('s',$value);
        }
        return $stmt;
    }
}