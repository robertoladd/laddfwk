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
    
}