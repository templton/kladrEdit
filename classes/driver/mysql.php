<?php

class Mysql {

    private static $db = null;
    private $mysqli;

    public function getDB() {
        if (self::$db == null)
            self::$db = new Mysql();
        return self::$db;
    }

    private function __construct() {
        $this->mysqli = new mysqli('localhost', 'root', '', 'tree');
        $this->mysqli->query("SET lc_time_names = 'ru_RU'");
        $this->mysqli->query("SET NAMES 'utf8'");
    }

    private function getQuery($query, $params) {
        if ($params) {
            for ($i = 0; $i < count($params); $i++) {
                $pos = strpos($query, $this->sym_query);
                $arg = "'" . $this->mysqli->real_escape_string($params[$i]) . "'";
                $query = substr_replace($query, $arg, $pos, strlen($this->sym_query));
            }
        }
        return $query;
    }

    public function select($query, $params = false) {
        
        //echo "<br>".$query."<br>";die;
        
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if (!$result_set) {
            echo '<h2 style="color:red">Ошибка mysql: ' . $this->mysqli->error . '</h2>';
            return false;
        }
        return $this->resultSetToArray($result_set);
    }

    public function query($query, $params = false) {
        $success = $this->mysqli->query($this->getQuery($query, $params));
        if ($success) {
            if ($this->mysqli->insert_id === 0)
                return true;
            else
                return $this->mysqli->insert_id;
        } else{
            echo '<h2 style="color:red">Ошибка mysql: ' . $this->mysqli->error . '</h2>';
            return false;
        }
    }

    private function resultSetToArray($result_set) {
        $array = array();
        while (($row = $result_set->fetch_assoc()) != false) {
            $array[] = $row;
        }
        return $array;
    }

    public function __destruct() {
        if ($this->mysqli)
            $this->mysqli->close();
    }

}
