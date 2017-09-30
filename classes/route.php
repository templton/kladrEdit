<?php

class Route
{
    public function __construct() {
    }

    public static function Route(){
        $action=new Main();
        $action->treeView();
    }
}
