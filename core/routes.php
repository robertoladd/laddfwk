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
            self::$_interface = 'other';
            self::loadRoutes();
        }
        self::$_interface = 'cli';
    }
    
    public static function dispatch(){
        if(self::$_interface == 'cli'){
           return self::dispatchCLI(); 
        }
    }
    
    protected function dispatchCLI(){
        global $argv;
        if(!ini_get('register_argc_argv')) throw new laddException('Disabled register_argc_argv ini parameter.', 0);
        
        $cmd_flags = array();
        foreach($argv as $k => $v){
            if($k==0)continue;
            
            if(stripos($v, '--')===0){
                if($v=='--help') $controller_args[0]='help';
                $flag=explode('=',$v);
                if(!isset($flag[1]))$flag[1] = true;
                $cmd_flags[str_replace('--', '', $flag[0])]=trim($flag[1]);
            }else{
                $controller_args[]=$v;
            }
        }
        
        $controller_name = '\\Controller\\'.ucfirst(strtolower($controller_args[0]));
        
        $method_name = $controller_args[1];
        $method_args = array();
        
        foreach($controller_args as $k => $v){
            if($k>1){
                $method_args[]=$v;
            }
        }
        
        if(!class_exists($controller_name))  throw new laddException("Unknown controller {$controller_name}.", 0);
        
        $controller = new $controller_name;
        Application::setCLIFlags($cmd_flags);
        
        if(!method_exists($controller, $method_name))  throw new laddException("Unknown method {$method_name}.", 0);
        
        call_user_func_array(array($controller,$method_name),$method_args);
    }
    
    public static function loadRoutes(){
        
        
    }
    
    public static function add($path, $controller, $controller_method, $http_method = 'ALL'){
        
    }
}
