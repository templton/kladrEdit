<?php

class Route {

    public function __construct() {
        
    }

    public static function Route() {

        if (isset($_GET['ajax'])) {

            $result = [];

            if (isset($_POST['action'])) {
                $actionName = $_POST['action'];
                    $filters = $_POST['filters'];
                    $action = new Actions();

                    if (method_exists($action, $actionName)) {
                        $result['data'] = $action->$actionName($filters);
                    } else {
                        //Либо вывести общее сообщение об ошибке, а в лог записать обращение к несуществующему методу
                        $result['error'] = 'Метод ' . $_POST['action'] . ' не существует.';
                    }
            }
            
            $search= (isset($_GET['search']) && strlen($_GET['search'])>3) ? $_GET['search'] : false;
            if ($search){
                $tree=new Tree();
                $result=$tree->getSearch($search);
            }

            echo json_encode($result);
        } else {
            $action = new Main();
            $action->treeView();
        }
    }

}
