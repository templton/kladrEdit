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
        $old_text=addslashes($filters['old_text']);
        $tree=new Tree();
        $result=$tree->edit($id, $text);
        
        //Сохранить инфо об изменении записи
        if ($result){
            $user=new User();
            $user->saveLog($id,$text, $old_text);
        }
        
        return true;
    }

}
