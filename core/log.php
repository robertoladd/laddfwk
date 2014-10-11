<?
namespace Core;

class Log{
    
    public static function __callStatic($method,$arguments) {
        if(method_exists('\\Core\\Log', $method)) {
            forward_static_call_array(array(self::NAME,$method),$arguments);
        }
        
        if(Routes::getInterface()=='cli'){
            if($method=='info' && Application::flag('verbose')){
                echo "\n".$arguments[0];
            }
            if($method=='progress'){
                echo $arguments[0]."\r";
            }
        }
    }
}