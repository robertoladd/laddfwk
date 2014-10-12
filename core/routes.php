<?

//    Copyright (C) 2014  Roberto Ladd
//    https://github.com/robertoladd/laddfwk
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
    
    const ANY = 0;
    const GET = 1;
    const POST = 2;
    const PUT = 3;
    const DELETE = 4;
    
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
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                $req_method = self::GET;
            break;
            case 'POST':
                $req_method = self::POST;
                if(isset($_POST['fake_method'])){//This is to allow browsers to use RESFULL PUT and DELETE non supported methods.
                    switch($_POST['fake_method']){
                        case 'PUT':
                            $req_method = self::PUT;
                        break;
                        case 'DELETE':
                            $req_method = self::DELETE;
                        break;
                    }
                }
            break;
            case 'PUT':
                $req_method = self::PUT;
            break;
            case 'DELETE':
                $req_method = self::DELETE;
            break;
        }
        
        
        
        self::dispatchRoute($req_method);
        
        self::dispatchRoute(self::ANY);
        
        $response = new Response('Not Found', 404);
        
        $response->respond();
    }
    
    protected static function dispatchRoute($req_method){
        global $CONFIG;
        
        if(!is_array(self::$_routes[$req_method])) return false;
        
        $wwwroot_parts= parse_url($CONFIG['wwwroot']);
        
        $rel_url = str_replace($wwwroot_parts['path'], '', $_SERVER['REQUEST_URI']);
        
        $rel_url = str_replace('?'.$_SERVER['QUERY_STRING'], '', $rel_url);
        
        foreach(self::$_routes[$req_method] as $route){
            $matches = array();
            if(preg_match($route['path_pattern'], $rel_url, $matches)){
                
                Log::info("Route pattern matches: ".print_r($matches, true));
                
                $controller_name = "\\Controller\\".$route['controller'];
                
                if(!class_exists($controller_name))  throw new laddException("Unknown controller {$controller_name}.", 0);
        
                $controller = new $controller_name;

                if(!method_exists($controller, $route['controller_method']))  throw new laddException("Unknown method {$route['controller_method']}.", 0);
                
                unset($matches[0]);
                
                $response = call_user_func_array(array($controller,$route['controller_method']),$matches);
        
                if(get_class($response)!= 'Core\\Response') throw new laddException("Unknown response type. Expected Response class object.");
                $response->respond();
            }
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
        global $CONFIG;
        include_once($CONFIG['path'].'/routes.php');
    }
    
    public static function add($path_pattern, $controller, $controller_method, $http_method = \Core\Routes::ANY){
        self::$_routes[$http_method][] = array('path_pattern'=>$path_pattern, 'controller'=> $controller, 'controller_method'=> $controller_method);
    }
}
