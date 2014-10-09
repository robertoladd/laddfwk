<?
namespace Core;


class Application{
	
	public function __construct(){}
        
        public function start(){
            \Core\Routes::init();
            \Core\Routes::dispatch();
        }

}


