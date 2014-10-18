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

class Response{
    
    protected $status_code;
    protected $content;
    protected $content_type;
    
    protected static $status_msgs = array(200=>"OK", 201=>"Created", 204=>"Done. No content" ,400=>"Wrong request", 404=>"Not Found", 500=>"Application error");



    public function __construct($content, $status_code=200, $content_type='text/html'){
        if(!is_int($status_code)) throw new laddException("Status code $status_code unaccepted type (".gettype($status_code).")");
        
        $this->status_code = $status_code;
        $this->content_type = $content_type;
        $this->content = $content;
        
    }
    
    public function respond(){
        
        if(\Core\Routes::getInterface() !='cli'){
            $protocol = (isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : 'HTTP/1.1');

            header($protocol." {$this->status_code} ".self::$status_msgs[$this->status_code]);
            header('Content-Type: '.$this->content_type);
        }
        
        echo $this->content;
        exit;
    }
}