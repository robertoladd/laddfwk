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
            if(in_array($key, static::$_field_map)) $this->$key = $value;
        }
    }
    
    public function save(){
        $dbo = \Core\DBConnection::getInstance();
        $fields_values = array();
        foreach($_field_map as $field){
            if(isset($this->{$field})){
                $fields_values[':'.$field] = $this->{$field};
                $fields_sets[$field]= "$field = :$field";
            }
        }
        
        
        //TODO: this should be done at driver level. Sorry :S
        $sql = "INSERT INTO {$dbo->database}.".static::$_table." SET ".implode(',', $fields_sets)."";
        
        //if update
        unset($fields_sets[static::$_instanceid]);
        
        $sql .= " ON DUPLICATE KEY UPDATE ".implode(',', $fields_sets)."";
        
        try{
            $res = $dbo->prepare($sql);
            $dbo->execute($res, $fields_values);
        }catch(PDOException $e){
            throw new laddException('Failed to save model record. ERR:'.$e->getMessage());
        }
        
        if($dbo->lastInsertId()>0){
            $this->{static::$_instanceid} = $dbo->lastInsertId();
        }
        
    }
    
    
    public function delete(){
        
        if($this->{static::$_instanceid}<1){
            \Core\Log::warning('Attempt to delete object without identifier. OBJ: '.print_r($this, true));
            return false;
        }
        $dbo = \Core\DBConnection::getInstance();
        $sql = "DELETE FROM {$dbo->database}.".static::$_table." WHERE {static::$_instanceid} =  {$this->{static::$_instanceid}}";
        
        try{
            $res = $dbo->query($sql);
        }catch(PDOException $e){
            throw new laddException('Failed to delete model record. ERR:'.$e->getMessage());
        }
        
        return (bool) $dbo->affectedRows($res);
    }
    
    
    public static function find($id){
        if(!is_numeric($id)) throw new laddException('Attempt to find model without numeric reference.');
        
        $dbo = \Core\DBConnection::getInstance();
        $sql = "SELECT * FROM {$dbo->database}.".static::$_table." WHERE {static::$_instanceid} = {$this->{static::$_instanceid}}";
        
        try{
            $res = $dbo->query($sql);
            $instanceClass = get_called_class();
            $instance = new $instanceClass($dbo->fetch($res));
        }catch(PDOException $e){
            throw new laddException('Failed to delete model record. ERR:'.$e->getMessage());
        }
        return $instance;
    }
    
    
    public static function all(){
        
        $dbo = \Core\DBConnection::getInstance();
        
        $sql = "SELECT * FROM {$dbo->database}.".static::$_table.";";
        
        $instances = array();
        
        try{
            $res = $dbo->query($sql);
            
            $instanceClass = get_called_class();
            while($row = $dbo->fetch($res)){
                $instances[] = new $instanceClass($row);
            }
        }catch(PDOException $e){
            throw new laddException('Failed to delete model record. ERR:'.$e->getMessage());
        }
        return $instances;
    }
    
    public static function mold(){
        $instanceClass = get_called_class();
        $instance = new $instanceClass();
        foreach(static::$_field_map as $field){
            $instance->$field;
        }
        return $instance;
    }
    
}