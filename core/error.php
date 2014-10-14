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

class Error{
    
    static $_types = array(1=>'Error', 2 =>'Warning', 8 => 'Notice');
    
    public static function handle($errno, $errstr, $errfile, $errline, $context){
        global $CONFIG;
        
        $message = View::get('500', array('error'=>$errstr, 'file'=>$errfile, 'line'=>$errline, 'type'=>self::$_types[$errno]));
        
        switch($CONFIG['debug']){
            case 0:
                mail($CONFIG['webmaster_email'], 'Website Error', $message);
            break;
            default:
                $response = new Response($message, 500);

                $response->respond();
            break;
        }
    }
}