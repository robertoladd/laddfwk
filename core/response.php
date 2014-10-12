<?

namespace Core;

class Response{
    
    protected $status_code;
    protected $content;
    protected static $status_msgs = array(404=>"Not Found",200=>"OK");



    public function __construct($content, $status_code=200){
        if(!is_int($status_code)) throw new laddException("Status code $status_code unaccepted type (".gettype($status_code).")");
        
        $this->status_code = $status_code;
        $this->content = $content;
    }
    
    public function respond(){
        header($_SERVER["SERVER_PROTOCOL"]." {$this->status_code} ".self::$status_msgs[$this->status_code]);
        echo $this->content;
    }
}