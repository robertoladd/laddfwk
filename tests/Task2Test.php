<?

/*
 * The following tests are not pretended for profiling. 
 * Instead they pretend to test the whole REST circuit, 
 * including routes and final output.
 * 
 */


class Task2Test extends PHPUnit_Framework_TestCase
{
    public function testCSVAddressRequest()
    {
        
        $this->expectOutputString('{"name":"Marcin","phone":"502145785","street":"Opata Rybickiego 1"}');
        echo file_get_contents(str_replace('8080', '80', \Core\Config::get('wwwroot')).'/address?id=1');
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    
    public function testExpect404Error()
    {
        
        echo file_get_contents(str_replace('8080', '80', \Core\Config::get('wwwroot')).'/address');
        
    }
}