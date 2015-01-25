<?php

namespace Core;


class Config{
    
    private static $parameters=array();
    
    
    public static function init(){
        
        $rootpath = __DIR__.'/../';
        static::$parameters = require $rootpath.'config.php';
        
        if(file_exists($rootpath.'config_overide/config.php')){
                static::$parameters = array_replace(static::$parameters, require $rootpath.'config_overide/config.php');
        }
    }
    
    
    protected static function initCheck(){
        if(count(static::$parameters)==0){
            self::init();
        }
    }
    
    public static function get($param){
        self::initCheck();
        
        if(!isset(static::$parameters[$param])){
            \Core\Log::warning('Attempt access non-existent "'.$param.'" configuration parameter');
        }
        return static::$parameters[$param];
    }
    
    
    public static function set($param, $value, $subparam=false){
        self::initCheck();
        
        if(!$param){
            \Core\Log::warning('Attempt set empty configuration parameter');
        }
        
        if(!$subparam){
            static::$parameters[$param] = $value;
        }else{
            if(!is_array(static::$parameters[$param])){
                \Core\Log::warning('Attempt set subvalue for a non array parameter');
            }
            
            static::$parameters[$param][$subparam] = $value;
        }
    }
    
}