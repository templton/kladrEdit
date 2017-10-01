<?php

/*
 * Класс для работы с деревом списка
 */

class Tree {

    public function __construct() {
        
    }

    //Только элементы первого уровня
    public function getDefaultTree() {
        $db = Application::getDB();
        $sql = 'SELECT * FROM class_okved WHERE parent_id IS NULL ORDER BY id';
        $data = $db->select($sql);
        return $data;
    }

    //Получить родительские элементы
    public function getChildTree($parent) {
        $db = Application::getDB();
        $sql = 'SELECT * FROM class_okved WHERE parent_id=' . $parent . ' ORDER BY id, parent_id';
        $data = $db->select($sql);
        return $data;
    }

    //Редактировать позицию
    public function edit($id, $text) {
        $db = Application::getDB();
        $sql = 'UPDATE class_okved SET `name`="' . $text . '" WHERE id=' . $id;
        $data = $db->query($sql);
        return $data;
    }

    //Получить все родительские элементы вверх по дереву
    //Для работы этой функции требуется выполнить миграцию procudure.sql
    public function getSearch($name) {
        $result = [];
        $db = Application::getDB();
        $sql = 'SELECT GROUP_CONCAT(id) as ids FROM class_okved WHERE name LIKE "%' . $name . '%"';
        $data = $db->select($sql);

        if (count($data) && isset($data[0]['ids'])) {
            $data = $data[0]['ids'];
            if (strlen($data)) {
                $sql = 'call get_in_parent("' . $data . '");';
                $result = $db->select($sql);
            }
        }

        return $result;
    }

}
