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

abstract class DBConnection{
    
    protected static $_instance = false;
    
    protected static $_connection = false;
    
    protected static $_params = false;
    
    protected static $_options = array('charset'=>'utf8');
    
    protected $username;
    
    protected $password;
    
    protected $host;
    
    protected $port;
    
    protected $auth;
    
    public $database;
    
    const DB_FETCH_OBJECT = 1;
    
    const DB_FETCH_ARRAY = 1;
    
    const DB_FETCH_ASSOC = 1;
    
    public function __construct($params){
        if(isset($params['username']))$this->username = $params['username'];
        if(isset($params['password']))$this->password = $params['password'];
        if(isset($params['host']))$this->host = $params['host'];
        if(isset($params['port']))$this->port = $params['port'];
        if(isset($params['auth']))$this->auth = $params['auth'];
        if(isset($params['database']))$this->database = $params['database'];
    }
    
    public static function getInstance(){//this would allow master/slave connections
        global $CONFIG;
        
        if(self::$_instance) return self::$_instance;
        else{
            switch($CONFIG['db_driver']){
                case 'mysql':
                default:
                    $driver =  'MySQLDB';
                break;
            }
            $driver = '\\Core\\DB\\'.$driver;
            if(!class_exists($driver, true)){
                throw new laddException("Attempt to initiate non existent db driver class {$driver}.");
            }
            
            self::$_instance=new $driver($CONFIG['db_driver_config']);
            
            self::$_instance->connect();
            
            return self::$_instance;
        }
    }
    
    public abstract function connect();
    
    public abstract function prepare($query, $options=array());
    
    public abstract function execute($result);
    
    public abstract function query($query);
    
    public abstract function numRows($result);
    
    public abstract function affectedRows($result);
    
    public abstract function fetch($result);
    
    public abstract function error($result);
    
    public abstract function errnum($result);
    
}