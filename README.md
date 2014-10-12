#laddfwk

A simple PHP 5.3+ MVC framework.

##Features:

* Command line interfase support for controllers.
    * Progress logging.
    * Verbose logging.
* Full non restricted PHP views. Yes, you can do anything php let's you do.. Don't!
* Class namespace based autoloading.
* Log handling.

##Code Examples

###Creating a new controller

File controller/test.php

```php
namespace Controller;

class Test extends \Core\Controller{
    
    public function helloworld($name, $surname){
        $this->display("raw","Hello, {$name} {$surname}!")));
    }
}
```

###Accesing our controllers via cli


```Shell

$php /var/www/laddfwk/cli.php test helloworld John Doe

```
The previous command would call hellowold method of our Test controller with John and Doe as method parameters.

Change php binary path and laddfwk path for your local instalation settings.



##TODO

* Add cli global help
* Add cli controller help support
* Error handling
* HTTP Status handling
* RESTFull support
* RegEXP Routing
* Persistence Layer
* Template views.
* A real fullstack framework. :)
