<?

$CONFIG['path'] = __DIR__;


include_once($CONFIG['path'].'/config.php');

if(file_exists($CONFIG['path'].'/config_overide/config.php')){
	include_once($CONFIG['path'].'/config_overide/config.php');
}

ini_set('display_errors', $CONFIG['debug']);

include_once($CONFIG['path'].'/core/autoload.php');


$application = new \Core\Application;

$application->start();