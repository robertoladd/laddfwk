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

class View {
    
    public static function get($view, $params){
        global $CONFIG;
        
        if(\Core\Routes::getInterface()=='cli'){
            $view_file = self::getPath($view, 'cli');
            if(file_exists($view_file)){
                
                extract($params);
                ob_start();
                include($view_file);
                
                return ob_get_clean();
            }else{
                
                $view_file = self::getPath('default', 'cli');
                $output = $params[0];
                ob_start();
                include($view_file);
                
                return ob_get_clean();
            }
                
        }
        
        $view_file = self::getPath($view);
        if(!file_exists($view_file)){
            throw new laddException("Undefined view {$view}.");
        }
        extract($params);
        ob_start();
        include($view_file);

        return ob_get_clean();
    }
    
    
    protected static function getPath($view, $sufix=''){
        global $CONFIG;
        if($sufix)$sufix ='.'.$sufix;
        return $CONFIG['path'].'/view/'.str_replace('.', '/', $view).$sufix.'.php';
    }
    
    public static function exists($view, $sufix=''){
        return file_exists(self::getPath($view, $sufix));
    }
}