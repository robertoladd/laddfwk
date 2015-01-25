<?php


class ResponseTest extends PHPUnit_Framework_TestCase
{
    
    function testRespondSetsProperContentStatusAndType(){
        
        $response_reflection = new \ReflectionClass('\Core\Response');
        $status_prop = $response_reflection->getProperty('status_code');
        $status_prop->setAccessible(true);
        $type_prop = $response_reflection->getProperty('content_type');
        $type_prop->setAccessible(true);
        $content_prop = $response_reflection->getProperty('content');
        $content_prop->setAccessible(true);
        
        $response = new \Core\Response('{"response":"Hello world"}', 400, 'text/json');
        
        $status_code = $status_prop->getValue($response);
        $content_type = $type_prop->getValue($response);
        $content = $content_prop->getValue($response);
        
        $this->assertEquals(400 , $status_code);
        $this->assertEquals('text/json' , $content_type);
        $this->assertEquals('{"response":"Hello world"}' , $content);
    }
    
    function testRespondSetsProperDefaultStatusAndType(){
        
        $response_reflection = new \ReflectionClass('\Core\Response');
        $status_prop = $response_reflection->getProperty('status_code');
        $status_prop->setAccessible(true);
        $type_prop = $response_reflection->getProperty('content_type');
        $type_prop->setAccessible(true);
        
        $response = new \Core\Response('Hello world');
        
        $status_code = $status_prop->getValue($response);
        $content_type = $type_prop->getValue($response);
        
        $this->assertEquals(200 , $status_code);
        $this->assertEquals('text/html' , $content_type);
    }
    
    /**
     * @expectedException \Core\laddException
     */
    
    function testRespondThrowsExceptionWithInvalidStatusCode(){
        
        $response = new \Core\Response('Hello world', "Invalid code");
    }
    
}