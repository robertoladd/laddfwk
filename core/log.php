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

class Log{
    
    public static function __callStatic($method,$arguments) {
        global $CONFIG;
        
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
        }else{
            switch($CONFIG['debug']){
                case 3:
                    if($method=='info') echo "\n".$arguments[0];
                case 2:
                    if($method=='warning') echo "\n".$arguments[0];
                case 1:
                    if($method=='error') echo "\n".$arguments[0];
                break;
            }
            
        }
    }
}