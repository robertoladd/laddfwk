<?php


class DBConnectionTest extends PHPUnit_Framework_TestCase
{
    
    function testGetInstanceReturnsADBConnectionInstance(){
        
        $db_instance = \Core\DBConnection::getInstance();
        
        $this->assertInstanceOf('\Core\DBConnection', $db_instance);
    }
    
}