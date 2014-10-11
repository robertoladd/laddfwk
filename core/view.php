<?

namespace Core;

class View {
    
    public function get($view, $params){
        global $CONFIG;
        
        if(\Core\Routes::getInterface()=='cli'){
            $view_file = $CONFIG['path'].'/view/'.$view.'.cli.php';
            if(file_exists($view_file)){
                
                extract($params);
                ob_start();
                include($view_file);
                
                return ob_get_clean();
            }else{
                
                $view_file = $CONFIG['path'].'/view/cli.php';
                $output = $params[0];
                ob_start();
                include($view_file);
                
                return ob_get_clean();
            }
                
        }
    }
}