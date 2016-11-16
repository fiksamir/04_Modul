<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 18.10.2016
 * Time: 20:07
 */

class DB {
    
    protected $connection;
    
    public function  __construct($host,$user,$password,$db_name)
    {

        $this->connection = new mysqli($host, $user, $password, $db_name);

        if (mysqli_connect_error()) {
            throw new Exception('Could not connect to ' . $db_name . ' data base');
        }
    }
    
    public function query($sql) {
        
        if (!$this->connection) {
            return false;
        }
        
        $result = $this->connection->query($sql);
        
        if (mysqli_error($this->connection)) {
            throw new Exception(mysqli_error($this->connection));
        }
        
        if (is_bool($result)) {
            return $result;
        }
        
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function escape($str) {
        return mysqli_escape_string($this->connection,$str);
    }
}