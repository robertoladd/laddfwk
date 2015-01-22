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
    
    static $_types = array(1024=>'Application Exception', 1=>'Error', 2 =>'Warning', 8 => 'Notice', 2048 => 'Strict');
    
    public static function handle($errno, $errstr, $errfile, $errline, $context){
        
        
        switch(Config::get('error_logging')){
            case 'email':
                self::email($errno, $errstr, $errfile, $errline, $context);
            break;    
            case 'file':
                self::file($errno, $errstr, $errfile, $errline, $context);
            break;    
            case 'both':
                self::email($errno, $errstr, $errfile, $errline, $context);
                self::file($errno, $errstr, $errfile, $errline, $context);
            break;
            default:        
            break;
        }
        
        if(Config::get('debug')){
            $errstr = nl2br($errstr);
            $message = View::get('500', array('error'=>$errstr, 'file'=>$errfile, 'line'=>$errline, 'type'=>self::$_types[$errno]));
            $response = new Response($message, 500);
            $response->respond();
        }
    }
    
    public static function email($errno, $errstr, $errfile, $errline, $context){
        
        $subject = strtoupper(self::$_types[$errno])." at (".Config::get('wwwroot').")";
        $errstr = nl2br($errstr);
        $message = View::get('500', array('error'=>$errstr, 'file'=>$errfile, 'line'=>$errline, 'type'=>self::$_types[$errno]));
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: '.Config::get('from_email') . "\r\n";

        return mail(Config::get('error_logging_email'), $subject, $message, $headers);
    }
    
    public static function file($errno, $errstr, $errfile, $errline, $context){
        
        $type = str_replace(' ', '_', strtolower(self::$_types[$errno]));
        $remote_addr = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'undefined');
        
        $message = "\n\r".date('Y-m-d H:i:s')."[{$remote_addr}] {$errfile}:{$errline} {$errstr}";
        $message = str_replace("\n", "\n\t", $message);
        
        //the day of the week is used as a simple log rotation method. Only the last 7 days will be available.
        $error_file = Config::get('path').'/logs/errors/'.$type.'.'.date('N').'.log';
        
        if(file_exists($error_file)){
            if(filemtime($error_file)< strtotime(date('Y-m-d 00:00:00'))){
                file_put_contents($error_file, 'Log file for '.date('Y-m-d')."\n====================\n\n");
            }
        }else file_put_contents($error_file, 'Log file for '.date('Y-m-d')."\n====================\n\n");
        
        file_put_contents($error_file, $message, FILE_APPEND);
    }
}