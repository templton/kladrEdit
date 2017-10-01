<?php

/*
 * Класс для обработки ajax запросов
 */

class Actions {

    public function __construct() {
        
    }

    public function getLists($filters) {
        
        $tree=new Tree();
        $data=$tree->getChildTree($filters['child']);
        
        return $data;
    }
    
    public function editItemTree($filters){
        $id=(int)$filters['id'];
        $text= addslashes($filters['text']);
        $tree=new Tree();
        return $tree->edit($id, $text);
    }

}
