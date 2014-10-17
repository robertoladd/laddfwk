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

class Model {
    
    protected static $_instanceid = 'id';
    
    protected static $_table = '';
    
    protected static $_disable_persistance=false;
    
    protected static $_field_map = array();
    
    public function __construct($attrs=array()){
        foreach($attrs as $key => $value){
            if(in_array((string)$key, static::$_field_map)) $this->$key = $value;
        }
    }
    
    public function save(){
        $dbo = \Core\DBConnection::getInstance();
        
        return $dbo->modelSave($this, static::$_field_map, static::$_table, static::$_instanceid);
    }
    
    
    public function delete(){
        
        if($this->{static::$_instanceid}<1){
            \Core\Log::warning('Attempt to delete object without identifier. OBJ: '.print_r($this, true));
            return false;
        }
        $dbo = \Core\DBConnection::getInstance();
        
        return $dbo->modelDelete($this, static::$_table, static::$_instanceid);
    }
    
    
    public static function find($id){
        if(!is_numeric($id)) throw new laddException('Attempt to find model without numeric reference.');
        
        $dbo = \Core\DBConnection::getInstance();
        $instanceClass = get_called_class();
        return $dbo->modelFind($id, $instanceClass, static::$_table, static::$_instanceid);
    }
    
    
    public static function all(){
        
        $dbo = \Core\DBConnection::getInstance();
        $instanceClass = get_called_class();
        
        return $dbo->modelAll($instanceClass, static::$_table);
    }
    
    public static function mold(){
        $instanceClass = get_called_class();
        $instance = new $instanceClass();
        foreach(static::$_field_map as $field){
            $instance->$field=null;
        }
        return $instance;
    }
    
}