<?

namespace Core;

class Routes{
    
    protected static $_interface;
    
    protected static $_routes;
    
    public static function getInterface(){
        return self::$_interface;
    }
    
    
    public static function init(){
        if(php_sapi_name() !== 'cli'){
            self::$_interface = 'cli';
            self::loadRoutes();
        }
        self::$_interface = 'other';
    }
    
    public static function dispatch(){
        if(self::$_interface = 'cli'){
           return self::dispatchCLI(); 
        }
    }
    
    protected function dispatchCLI(){
        global $argv;
        if(!ini_get('register_argc_argv')) throw new laddException('Disabled register_argc_argv ini parameter.', 0);
        
        $controller_name = '\\Controller\\'.ucfirst(strtolower($argv[1]));
        $method_name = $argv[2];
        $method_args = array();
        
        foreach($argv as $k => $v){
            if($k>2){
                $method_args[]=$v;
            }
        }
        
        if(!class_exists($controller_name))  throw new laddException("Unknown controller {$controller_name}.", 0);
        
        $controller = new $controller_name;
        
        if(!method_exists($controller, $method_name))  throw new laddException("Unknown method {$method_name}.", 0);
        
        call_user_func_array(array($controller,$method_name),$method_args);
    }
    
    public static function loadRoutes(){
        
        
    }
    
    public static function add($path, $controller, $controller_method, $http_method = 'ALL'){
        
    }
}
