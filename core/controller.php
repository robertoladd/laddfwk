<?
namespace Core;

class Controller{
    protected function display($view, $params=array()){
        
        echo View::get($view, $params);
    }
}