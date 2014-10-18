#laddfwk

A simple PHP 5.3+ MVC framework.

https://github.com/robertoladd/laddfwk

##Features:

* Command line interfase support for controllers.
    * Progress logging.
    * --verbose.
    * --help.
        * global help.
        * controller help.
* Full non restricted PHP views. Yes, you can do anything php let's you do.. Don't!
* Class namespace based autoloading.
* Log handling.
* HTTP Status handling.
* RESTFull support.
* RegEXP Routing.
* Configuration file overide (for multi-enviroment support).

##Code Examples

###Creating a new controller

File controller/[test].php

**Replace test with your own controller's name**

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

$php /var/www/laddfwk/cli.php home welcome John

```
The previous command would call hellowold method of our Test controller with John and Doe as method parameters.

Change php binary path and laddfwk path for your local instalation settings.

To add help to your controller add a view in view/[controller]/help.cli.php

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

In view/[controller]/home.php

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

###Routing

Routing allows you to define which routes will resolve to your controllers


In routes.php

```php
\Core\Routes::add('/^\/welcome(?:\/(.*?))*$/i', 'home', 'welcome', \Core\Routes::ANY);

\Core\Routes::add('/^\/$/i', 'home', 'welcome', \Core\Routes::ANY);

```
Both routes resolve any kind of http method received. Particular method routes will precede generic ones.

Notice that when placing paths with a common method, the placement order is important.


###ActiveRecord Models

When creating a new model class as in the following example 

model/[address].php

**Replace address with your own models's name**

```php

namespace Model;

class Address extends \Core\Model{
    
    protected static $_table = 'addresses';
    
    protected static $_field_map = array('id', 'name', 'phone_number', 'address', 'ts_created', 'ts_updated');
    
    
}

```

As you can see, all you need is to define the name of the table and fields to be used, a primary key "id" is always expected, but can also be re-defined setting $_instanceid static variable.
After creating our new model save and delete methods will be available. save is used for both creation and update actions. 

Also "all" and "find" static methods are available, wich will return an array or a single model's object correspondingly.


```php

$id = (int) $_GET['id'];

$address = \Model\Address::find($id);

if(isset($address->id)){
    $address->ts_updated = date('Y-m-d H:i:s');
    if($address->save()){
        return $this->status204();
    }
    
}else{
    return $this->status404();
}

```

##TODO


* Error handling
* Vagrant development enviroment.
* Template views
* Multi-lang support
* A real fullstack framework. :)
