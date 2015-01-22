<?

namespace Controller;

use Core\Config as Config;

class Task2 extends \Core\Controller{
    
    protected $addresses = array();
    
    public function address($id=false, $as_html=false){
        $id = $id-1;//human friendly id's
        
        //this is to support original example's behavior
        if(isset($_GET['id'])) $id = (int) $_GET['id'];
            
        $this->loadAddresses();
        if(!isset($this->addresses[$id])){
            return $this->status404();
        }
        
        if($as_html){
            return $this->display('addresses', array('addresses'=>array($this->addresses[$id])));
        }
        else return $this->display('raw', json_encode($this->addresses[$id]), 200, 'application/json');
        
    }
    
    public function addresses($as_html=false){
        $this->loadAddresses();
        
        if($as_html){
            return $this->display('addresses', array('addresses'=>$this->addresses));
        }
        else return $this->display('raw', json_encode($this->addresses), 200, 'application/json');
    }
    
    protected function loadAddresses(){
        
        $file = fopen(Config::get('path').'/storage/example.csv', 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            $this->addresses[] = array(
                'name' => $line[0],
                'phone' => $line[1],
                'street' => $line[2]
            );
        }

        fclose($file);
        
    }
}