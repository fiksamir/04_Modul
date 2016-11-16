<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 19.10.2016
 * Time: 17:33
 */

class User extends Model {
    public function getByLogin($login) {
        $login = $this->db->escape($login);
        $sql = "select * from users where login='{$login}' limit 1";
        $result = $this->db->query($sql);
        
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }
}