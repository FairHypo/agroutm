composer require fairhypo/agroutm
================

Library for Agro24 project to add some utm functionality.




## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "fairhypo/agroutm": "^1.0"
        }
    }

```


### Laravel 5.* Integration

Add the service provider to your `config/app.php` file:

```php

    'providers'     => array(

        //...
        Fairhypo\Agroutm\AgroutmServiceProvider::class,

    ),
    
```

Publish the migrations

```bash

    php artisan vendor:publish --provider="Fairhypo\Agroutm\AgroutmServiceProvider"
    
```

... and use it

```bash

    php artisan migrate
    
```


Add the middleware to your `App\Http\Kernel.php` file:

```php

    protected $routeMiddleware = [
            //...
            'agroutm' => \Fairhypo\Agroutm\Middleware\AgroUtm::class,
        ];

```

Then use in your routes:

```php

    Route::get('/', function () {
        //
    })->middleware('agroutm');

```


... or include into other middleware:

```php

    protected $middlewareGroups = [
        'web' => [
            //...
            'agroutm',
        ],
        //...
    ];

```


## Usage

### Using Agroutm middleware

You do not need to do something else. Just test that everything works fine.



## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)




## Contact

Yuriy Maslov (developer)

- Email: yuriy.maslof@gmail.com