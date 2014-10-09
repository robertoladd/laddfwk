<?


spl_autoload_register(function ($class) {
    global $CONFIG;
    $parts = explode('\\', $class);
    foreach($parts as $k => $part){
        $parts[$k] = lcfirst($part);
    }
    $path = implode('/', $parts);
    include $CONFIG['path'].'/'.$path . '.php';
});
