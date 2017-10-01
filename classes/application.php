<?php

/*
 * Главный класс приложения
 */

require_once 'driver/mysql.php';
require_once 'driver/postgresql.php';

class Application {
    
    protected static $config=[];
    protected static $assets=[
        'js'=>[],
        'css'=>[]
    ];

    public function __construct($config) {
        self::$config=$config;
        self::setAssets();
    }
    
    public static function getDB($driver='Mysql'){
        if ($driver=='Mysql'){
            return Mysql::getDB();
        }
    }
    
    public static function getConfig(){
        return self::$config;
    }
    
    private static function setAssets(){
        self::$assets=[
            'js'=>[
                'jquery-3.2.1.min.js',
                'bootstrap.min.js',
                'functions.js'
            ],
            'css'=>[
                'bootstrap.min.css',
                'style.css'
            ]
        ];
    }
    
    public static function getAssets(){
        $assets='';
        $assets.="\r\n<!-- Скрипты -->\r\n";
        foreach (self::$assets['js'] as $item){
            $assets.="\r\n".'<script src="web/assets/js/'.$item.'"></script>';
        }
        $assets.="\r\n\r\n<!-- Таблицы стилей -->\r\n";
        foreach (self::$assets['css'] as $item){
            $assets.="\r\n".'<link rel="stylesheet" type="text/css" href="web/assets/css/'.$item.'" >';
        }
        $assets.="\r\n\r\n";
        return $assets;
    }
    
    
}

