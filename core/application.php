<?
namespace Core;


class Application{
	
        private static $_flags;
        
	public function __construct(){}
        
        public function start(){
            \Core\Routes::init();
            \Core\Routes::dispatch();
        }
        
        public static function setCLIFlags($flags){
            if(!is_array($flags)) throw new laddException('Flags must be an array.', 1);
            
            self::$_flags = $flags;
        }
        
        public function flag($flag){
            if(!isset(self::$_flags[$flag])) return;
            
            return self::$_flags[$flag];
        }

}


