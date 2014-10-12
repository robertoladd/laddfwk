<?

//    Copyright (C) 2014  Roberto Ladd
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.


namespace Core;

class Routes{
    
    protected static $_interface;
    
    protected static $_routes;
    
    public static function getInterface(){
        return self::$_interface;
    }
    
    
    public static function init($cli=false){
        if(!$cli){
            self::$_interface = 'other';
            self::loadRoutes();
        }else
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
        
        $response = call_user_func_array(array($controller,$method_name),$method_args);
        
        if(get_class($response)!= 'Core\\Response') throw new laddException("Unknown response type. Expected Response class object.");
        $response->respond();
    }
    
    public static function loadRoutes(){
        
        
    }
    
    public static function add($path, $controller, $controller_method, $http_method = 'ALL'){
        
    }
}
