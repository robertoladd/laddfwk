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

class Controller{
    protected function display($view, $params=array(), $status_code=200, $content_type = ''){
        
        if(!is_int($status_code)) throw new laddException("Status code $status_code unaccepted type (".gettype($status_code).")");
        
        if($view=='raw') return new Response((string) $params, $status_code, $content_type);
        
        $classname = str_replace('controller\\', '', strtolower(get_class($this)));
        if($classname == 'help' && $view != 'help'){
            $classname = $view;
            $view = 'help';
        }
        
        return  new Response(View::get($classname.'.'.$view, $params), $status_code, $content_type);
    }
    
    
    protected function status404($message='Not Found'){
        return $this->display('raw', $message, 404);
    }
    
     function status200($message='OK'){
        return $this->display('raw', $message, 200);
    }
    
    protected function status201($message='Created'){
        return $this->display('raw', $message, 201);
    }
    
    protected function status204($message='Done. No content.'){
        return $this->display('raw', $message, 204);
    }
    
    public function help($controller=false){
        $view = "help";
        
        if($controller && !View::exists($controller.'.'.$view, 'cli')){
            return $this->display('raw', "No help found for controller {$controller}.\n", 404);
        }elseif($controller){
            $view = $controller;
        }
                
        return  $this->display($view);
    }
}