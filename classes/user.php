<?php

class User {

    public function __construct() {
        
    }

    public function getUserIP() {
        //Тут может быть обработка ip
        return $_SERVER['REMOTE_ADDR'];
    }
    
    public function saveLog($id, $new_text, $old_text){
        $ip=$this->getUserIP();
        $db= Application::getDB();
        $sql='INSERT 
                INTO userlog (item_id, old_name, new_name, user_ip, timestamp)
                VALUES
                ('.$id.', "'.$old_text.'","'.$new_text.'","'.$ip.'", NOW())
                ';
        $res=$db->query($sql);
        return $res;
    }
}
    