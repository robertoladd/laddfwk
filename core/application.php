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


class Application{
	
        private static $_flags;
        
	public function __construct(){}
        
        public function start($cli){
            \Core\Routes::init($cli);
            \Core\Routes::dispatch();
        }
        
        public static function setCLIFlags($flags){
            if(!is_array($flags)) throw new laddException('Flags must be an array.', 1);
            
            self::$_flags = $flags;
        }
        
        public function flag($flag){
            if(!isset(self::$_flags[$flag])) return;
            
            return self::$_flags[$flag];
        }

}


