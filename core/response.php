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
    protected static $status_msgs = array(404=>"Not Found",200=>"OK");



    public function __construct($content, $status_code=200){
        if(!is_int($status_code)) throw new laddException("Status code $status_code unaccepted type (".gettype($status_code).")");
        
        $this->status_code = $status_code;
        $this->content = $content;
    }
    
    public function respond(){
        header($_SERVER["SERVER_PROTOCOL"]." {$this->status_code} ".self::$status_msgs[$this->status_code]);
        
        echo $this->content;
        exit;
    }
}