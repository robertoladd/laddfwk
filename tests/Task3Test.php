<?

/*
 * The following tests are not pretended for profiling. 
 * Instead they pretend to test the whole REST circuit, 
 * including routes and final output.
 * 
 */

$CONFIG['path'] = __DIR__.'/..';


include_once($CONFIG['path'].'/config.php');

if(file_exists($CONFIG['path'].'/config_overide/config.php')){
	include_once($CONFIG['path'].'/config_overide/config.php');
}


class Task3Test extends PHPUnit_Framework_TestCase
{
    private $address;
    
    public function testExpectEmptyAddresObject()
    {
        global $CONFIG;
        
        
        $this->expectOutputString('{"id":null,"name":null,"phone_number":null,"address":null,"ts_created":null,"ts_updated":null}');
        echo file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address/form');
    }
    
    /**
     *
     * @global array $CONFIG 
     */
    
    
    public function testExpectCURLCreate()
    {
        global $CONFIG;
        
        
        //creation
        
        $data = array("name"=>"Unit Test","phone_number"=>"555 55 55 55","address"=>"Ballsbridge 2");
        $data_str = http_build_query($data);
        $options = array(
            'http'=>array(
                'method'=>"POST",
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($data_str) . "\r\n",
                'content' => $data_str
            )
        );

        $context = stream_context_create($options);
        
        $address_str =  file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address', false, $context);
        $address = json_decode($address_str, true);
        
        $this->assertEquals(true, is_array($address));//Our recently created record must exist.
        
        $address_id = $address['id'];
        
        unset($address['id']);
        unset($address['ts_created']);
        unset($address['ts_updated']);
        
        $this->assertEquals($address, $data);//Our recently created matches our sent record.
        
        $address['id'] = $address_id;
        
        return $address;
    }
    
    
    /**
     * @depends testExpectCURLCreate
     */
    
    public function testExpectCURLReadAll(array $address)
    {
        global $CONFIG;
        
        $address_id = $address['id'];
        
        //read
        $addresses =  file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address');
        $addresses = json_decode($addresses, true);
        
        $this->assertEquals(true, (count($addresses)>0));//at least one record must exist.
        
        foreach($addresses as $address){
            if($address["id"] == $address_id){
                $test_address = $address;
            }
        }
        
        $this->assertEquals(true, is_array($test_address));//Our recently created record must exist.
        
        $test_address["id"] = $address_id;
        
        return $test_address;
    }
        
    
    /**
     * @depends testExpectCURLReadAll
     */
    
    public function testExpectCURLUpdate(array $test_address)
    {
        global $CONFIG;
        
        //update

        $test_address["name"] = "Unit Test Updated";
        $test_address["phone_number"] = "444 44 44 44";
        $test_address["address"] = "Ballsbridge 3";
        $data_str = http_build_query($test_address);
        $options = array(
            'http'=>array(
                'method'=>"POST",
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($data_str) . "\r\n",
                'content' => $data_str
            )
        );

        $context = stream_context_create($options);
        
        $address_str =  file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address/'.$test_address['id'], false, $context);
        
        $address = json_decode($address_str, true);
        
        unset($address['ts_created']);
        unset($address['ts_updated']);
        
        $this->assertEquals($address, $test_address);//Our recently updated matches our sent updated record.
        
        return $address;
        
    }
    
    /**
     * @depends testExpectCURLUpdate
     */
    
    public function testExpectCURLReadOne(array $address)
    {
        global $CONFIG;
        //read with index
        $address_str =  file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address/'.$address['id']);
        $addresses_updated = json_decode($address_str, true);
        
        $this->assertEquals($address, $addresses_updated);//Our recently updated matches our requested address.
        
        return $addresses_updated;
    }
    
    
    /**
     * @depends testExpectCURLReadOne
     */
    
    public function testExpectCURLDelete(array $addresses_updated)
    {
        global $CONFIG;
    
        //delete
        $options = array(
            'http'=>array(
                'method'=>"DELETE"
            )
        );
        
        $context = stream_context_create($options);
        
        $this->expectOutputString('Done. No content.');
        
        echo   file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address/'.$addresses_updated['id'], false, $context);
        
        //Verify that it really doesn't exist anymore
        $this->assertEquals(false, @file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/t3/address/'.$addresses_updated['id']));
        
        
    }
}