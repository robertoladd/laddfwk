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

namespace Core\DB;
use PDO;

class MySQLDB extends \Core\DBConnection{
    
    public function connect(){
        try{
            self::$_connection = new PDO (
                "mysql:host={$this->host};port={$this->port};dbname={$this->database}",
                $this->username, 
                $this->password, 
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".self::$_options['charset'])
            );
        }
        catch(PDOException $e){
                throw new \Core\laddException('MySQLDB Connection failed. ERR:'.$e->getMessage());
        }
    }
    
    /**
     *
     * @param type $query
     * @param type $params
     * @return PDOStatement Object 
     */
    
    public function prepare($query, $params=array()){
        return self::$_connection->prepare($query, $params);
    }
    
    /**
     *
     * @param PDOStatement $ref
     * @return \PDOStatement|boolean 
     */
    
    public function execute($ref){
        if($ref->execute()) return $ref;
        else return false;
    }
    
    /**
     *
     * @param type $query
     * @param type $params - PDO::query params
     * @return type 
     */
    
    public function query($query, $params = array()){
        if(count($params)>0){
            array_unshift($params, $query);
            return call_user_func(array(self::$_connection, 'query'), $params);
        }else{
            return self::$_connection->query($query);
        }
    }
    
    /**
     *
     * @param PDOStatement $result
     * @return type 
     */
    
    public function numRows($result){
        return $res->rowCount();
    }
    
    /**
     *
     * @param PDOStatement $result
     * @return type 
     */
    public function affectedRows($result){
        return $res->rowCount();
    }
    
    /**
     *
     * @param PDOStatement $result
     * @param Array $params - PDO::fetch params
     * @return type 
     */
    
    public function fetch($result, $params = array()){
        if(count($params)>0){
            return call_user_func(array($result, 'fetch'), $params);
        }else
            return $result->fetch();
    }
    
    /**
     *
     * @param PDOStatement $result
     * @param type $params - PDO::fetchAll params
     * @return type 
     */
    
    public function fetchAll($result, $params = array()){
        if(count($params)>0){
            return call_user_func(array($result, 'fetchAll'), $params);
        }else
            return $result->fetchAll();
    }
    
    /**
     *
     * @param NULL $result
     * @return type 
     */
    
    public function error($result=null){
        return self::$_connection->errorInfo();
    }
    
    /**
     *
     * @param NULL $result
     * @return type 
     */
    
    public function errnum($result=null){
        return self::$_connection->errorCode();
    }
}