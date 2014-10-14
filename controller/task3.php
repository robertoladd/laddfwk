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
    
    public function delete($id, $as_json=false){
        if(!\Core\Validator::int($id)){
            return $this->status404();
        }
        $address = \Model\Address::find($id);
        
        if($address->id<0){
            return $this->status404();
        }
        $address->delete();
        return $this->status200();
    }
    
    public function create($as_json=false){
        
    }
    
    public function update($as_json=false){
        
    }
    
    public function form($id=false, $as_json=false){
        if($id){
            if(!\Core\Validator::int($id)){
                return $this->status404();
            }
            $address = \Model\Address::find($id);

            if($address->id<0){
                return $this->status404();
            }
            
        }else{
            $address = \Model\Address::mold($id);
        }
        
        if($as_json){
            return $this->display('raw', json_encode($address), 200, 'application/json');
        }
        
        else return $this->display('address_form', array('address'=>$address));
    }
    
    public function index($id=false, $as_json=false){
        if($id){
            if(!\Core\Validator::int($id)){
                return $this->status404();
            }
            $address = \Model\Address::find($id);

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
        
        if($as_json){
            return $this->display('raw', json_encode($json_res), 200, 'application/json');
        }
        
        else return $this->display('addresses', array('addresses'=>$res));
    }
}