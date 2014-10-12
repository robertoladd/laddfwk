#laddfwk

A simple PHP 5.3+ MVC framework.

https://github.com/robertoladd/laddfwk

##Features:

* Command line interfase support for controllers.
    * Progress logging.
    * Verbose logging.
* Full non restricted PHP views. Yes, you can do anything php let's you do.. Don't!
* Class namespace based autoloading.
* Log handling.
* HTTP Status handling.
* RESTFull support.
* RegEXP Routing.
* Configuration file overide (for multi-enviroment support).

##Code Examples

###Creating a new controller

File controller/test.php

```php
namespace Controller;

class Home extends \Core\Controller{
    
    public function welcome($name){
        return $this->display("raw","Hello, {$name} {$surname}!");
    }
}
```

###Accesing our controllers via cli


```Shell

$php /var/www/laddfwk/cli.php test helloworld John Doe

```
The previous command would call hellowold method of our Test controller with John and Doe as method parameters.

Change php binary path and laddfwk path for your local instalation settings.


###Controllers and views

A controller call from browser using a view.

```php
namespace Controller;

class Home extends \Core\Controller{
    
    public function welcome($name){
        return $this->display('home', array('name'=>$name));
    }
}
```

In view/home.php

```php
<html>
    <head>
        <title>Default laddfwk home page</title>
    </head>
    <body>
        
        <h1>Welcome <?=ucwords($name)?>!</h1>
        <p>This is the default framework page.</p>
        <p>For code examples check <a href="https://github.com/robertoladd/laddfwk">https://github.com/robertoladd/laddfwk</a></p>
    </body>
</html>

```

In routes.php

```php
\Core\Routes::add('/^\/welcome(?:\/(.*?))*$/i', 'home', 'welcome', \Core\Routes::ANY);

\Core\Routes::add('/^\/$/i', 'home', 'welcome', \Core\Routes::ANY);

```
Both routes resolve any kind of http method received. Particular method routes will precede generic ones.

Notice that when placing paths with common a method, the placement order is important.


##TODO


* Add cli global help
* Add cli controller help support
* Error handling
* Persistence Layer
* Vagrant development enviroment.
* Template views
* Multi-lang support
* A real fullstack framework. :)
