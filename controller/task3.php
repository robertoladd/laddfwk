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


namespace Controller;

class Task3 extends \Core\Controller{
    
    public function delete($id, $as_html=false){
        
        $address = \Model\Address::find((int) $id);
        
        if(!isset($address->id)) return $this->status404();
        if($address->id<0) return $this->status404();
        
        $address->delete();
        
        if($as_html){
            return $this->display('success_message', array('action'=>'Delete'), 200);
        }
        
        return $this->status204();
    }
    
    public function create($as_html=false){
        
        
        $validations = array(
            'required'=> array('name'=>'string', 'phone_number'=>array('string'), 'address'=>array('string')),
            'optional'=>array()
        );
        if(($result = \Core\Validator::multi($_POST, $validations)) !== true){
            if($as_html){
                return $this->display('errors_message', array('errors'=>$result), 400);
            }else{
                return $this->display('raw', json_encode(array('errors'=>$result)), 400);
            }
        }
        
        $params = array('name'=>$_POST['name'], 'phone_number'=>$_POST['phone_number'], 'address'=>$_POST['address']);
        $address = new \Model\Address($params);
        
        if($address->save()){
            if($as_html){
                return $this->display('success_message', array('action'=>'Create'), 200);
            }else{
                return $this->status201(json_encode($address));
            }
        }
        throw new \Core\laddException('Failed to save task3 resource');
    }
    
    public function update($id, $as_html=false){
        
        $address = \Model\Address::find((int) $id);
        
        if(!isset($address->id)) return $this->status404();
        if($address->id<0) return $this->status404();
        
        $validations = array(
            'required'=> array('name'=>'string', 'phone_number'=>array('string'), 'address'=>array('string')),
            'optional'=>array()
        );
        if(($result = \Core\Validator::multi($_POST, $validations)) !== true){
            if($as_html) return $this->display('errors_message', array('action'=>'Create'), 400);
            else{
                return $this->display('raw', json_encode(array('errors'=>$result)), 400);
            }
        }
        
        
        $address->name=$_POST['name'];
        $address->phone_number=$_POST['phone_number'];
        $address->address=$_POST['address'];
        
        
        if($address->save()){
            if($as_html){
                return $this->display('success_message', array('action'=>'Update'), 200);
            }else{
                return $this->status204(json_encode($address));
            }
        }
        throw new \Core\laddException('Failed to save task3 resource');
    }
    
    
    public function form($id=false, $as_html=false){
        if($id){
            
            $address = \Model\Address::find((int) $id);

            if($address->id<0){
                return $this->status404();
            }
            
        }else{
            $address = \Model\Address::mold($id);
        }
        
        if($as_html){
            return $this->display('address_form', array('address'=>$address));
        }
        else return $this->display('raw', json_encode($address), 200, 'application/json');
    }
    
    public function index($id=false, $as_html=false){
        
        if($id){
            
            $address = \Model\Address::find((int) $id);

            if($address->id<0){
                return $this->status404();
            }
            
            $json_res = $address;
            $res = array($address);
            
        }else{
            $addresses = \Model\Address::all();
            $json_res = $addresses;
            $res = $addresses;
        }
        
        if($as_html){
            return $this->display('addresses', array('addresses'=>$res));
        }
        else return $this->display('raw', json_encode($json_res), 200, 'application/json');
    }
}