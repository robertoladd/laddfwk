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

class Controller{
    protected function display($view, $params=array(), $status_code=200){
        
        if(!is_int($status_code)) throw new laddException("Status code $status_code unaccepted type (".gettype($status_code).")");
        
        if($view=='raw') return new Response($view, $status_code);
        
        return  new Response(View::get($view, $params), $status_code);
    }
    
    
    protected function status404($message){
        return $this->display('404', array($message), 404);
    }
}