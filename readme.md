# payamsms package for laravel

> Install :

	

    composer require pgsavis/payamsms

> providers:

    pgsavis\payamsms\payamsmsServiceProvider::class,

> aliases:

    'Smssabanovin' => pgsavis\payamsms\payamsmsFacade::class,

> publish config :

    php artisan vendor:publish --provider=pgsavis\payamsms\payamsmsServiceProvider

> set config in /config/payamsms.php
> 
    'BASEURL' => 'http://www.payamsms.com/rest/',
    'APIKEY' => '',
    'PASS' => '',
    'FROM' => ''
> usage:

    \payamsms::sendNewMessage($to,$message);

