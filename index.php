<?php
/*
 * Инициализация приложения
 */

require_once 'config/config.php';
require_once 'classes/tree.php';
require_once 'classes/route.php';
require_once 'classes/application.php';
require_once 'web/main.php';

$App=new Application($config);

$tree=new Tree();

Route::Route();



/*
$conn=$App::getDB(Application::getConfig()['driverDB']);
$sql='SELECT * FROM class_okved WHERE id=10';
print_r($conn->select($sql));
 * 
 */

