<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{
    function testConfigLoadsAndReturnsPath(){
        $path = \Core\Config::get('path');
        $this->assertNotEmpty($path);
    }
    
    function testConfigSetsBaseParameter(){
        
        \Core\Config::set('test_param', 'test_value');
        
        $param = \Core\Config::get('test_param');
        
        $this->assertEquals($param, 'test_value');
    }
    
    function testConfigSetsSubParameter(){
        
        \Core\Config::set('test_param', array());
        \Core\Config::set('test_param', 'test_value', 'test_subparam');
        
        $param = \Core\Config::get('test_param');
        
        $this->assertEquals($param['test_subparam'], 'test_value');
    }
}