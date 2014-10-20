<?

$CONFIG['path'] = __DIR__.'/..';


include_once($CONFIG['path'].'/config.php');

if(file_exists($CONFIG['path'].'/config_overide/config.php')){
	include_once($CONFIG['path'].'/config_overide/config.php');
}


class Task2Test extends PHPUnit_Framework_TestCase
{
    public function testCSVAddressRequest()
    {
        global $CONFIG;
        
        
        $this->expectOutputString('{"name":"Marcin","phone":"502145785","street":"Opata Rybickiego 1"}');
        echo file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/address?id=1');
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    
    public function testExpect404Error()
    {
        global $CONFIG;
        
        echo file_get_contents(str_replace('8080', '80', $CONFIG['wwwroot']).'/address');
        
    }
}