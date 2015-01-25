<?php


class ControllerTest extends PHPUnit_Framework_TestCase
{
    
    function testDisplayReturnsRawViewResponse(){
        
        
        $controller_reflection = new \ReflectionClass('\Core\Controller');
        $display_method = $controller_reflection->getMethod('display');
        $display_method->setAccessible(true);
        
        $controller = new \Core\Controller;
        
        $response = $display_method->invokeArgs($controller, array('raw', 'test response text'));
        
        $this->assertInstanceOf('\Core\Response', $response);
    }
    
    
    /**
    * @dataProvider providerTestStatusMethods
    */
    
    function testStatusMethodsReturnProperStatusResponses($status){
        
        $controller_reflection = new \ReflectionClass('\Core\Controller');
        $status_method = $controller_reflection->getMethod('status'.$status);
        $status_method->setAccessible(true);
        
        $response_reflection = new \ReflectionClass('\Core\Response');
        $status_prop = $response_reflection->getProperty('status_code');
        $status_prop->setAccessible(true);
        $content_prop = $response_reflection->getProperty('content');
        $content_prop->setAccessible(true);

        
        $controller = new \Core\Controller;

        $response = $status_method->invokeArgs($controller, array('test response text'));
        
        $status_code = $status_prop->getValue($response);
        $content = $content_prop->getValue($response);

        $this->assertInstanceOf('\Core\Response', $response);
        $this->assertEquals($status , $status_code);
        $this->assertEquals('test response text' , $content);
    }
    
    
    public function providerTestStatusMethods()
    {
        return array(
            array('200'),
            array('201'),
            array('204'),
            array('404'),
        );
    }
    
}