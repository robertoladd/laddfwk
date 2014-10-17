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

class Validator{
    
    public static function int($var){
        return is_int($var);
    }
    
    public static function float($var){
        return is_float($var);
    }
    
    public static function number($var){
        return is_numeric($var);
    }
    
    public static function string($var){
        return is_string($var);
    }
    
    public static function alfanum($var){
        return filter_var($var, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z0-9]*$/i")));
    }
    
    public static function email($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }
    
    public static function ip($var){
        return filter_var($var, FILTER_VALIDATE_IP);
    }
    
    public static function multi($params, $validations){
        $results = array();
        $return = true;
        foreach($validations as $required => $validations2){
            
            $required = $required == 'required';//leave it as boolean
            
            foreach($validations2 as $param => $param_validations){
                if(is_string($param_validations)){//this is to accept single validations as a direct string
                    $param_validations = array($param_validations);
                }
                foreach($param_validations as $param_validation){
                    
                    if(!method_exists('\\Core\\Validator', $param_validation)) throw new laddException('Attempt to use undefined validation method!');
                            
                    if(!$required || !empty($params[$param])){
                        
                        if(!isset($results[$param]))$results[$param]=array();
                        
                        $results[$param][$param_validation] = self::$param_validation($params[$param]);
                        if(!$results[$param][$param_validation]) $return = false;
                        
                    }elseif($required){
                        $results[$param][$param_validation] = false;
                        $return = false;
                    }
                }
            }
        }
        
        return ($return ? $return : $results);
    }
    
}