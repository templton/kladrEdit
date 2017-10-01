<?php

class Main
{
    public function __construct() {
    }
    
    public function treeView(){
        $tree=new Tree();
        
        $items=$tree->getDefaultTree();
        
        require_once 'web/view/mainView.php';
    }
}

