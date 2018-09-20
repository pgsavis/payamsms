<?php
/**
 * Created by PhpStorm.
 * User: Jamal
 * Date: 9/20/2018
 * Time: 7:25 PM
 */

namespace pgsavis\payamsms;


use Illuminate\Support\ServiceProvider;

class payamsmsServiceProvider extends ServiceProvider
{
    public  function register(){
        $this->app->bind('payamsms',function(){
            return new payamsms();
        });

        $this->mergeConfigFrom(__DIR__.'/Config/main.php','payamsms');
    }

    public function boot(\Illuminate\Routing\Router $router){
        require (__DIR__ . '\Http\routes.php');

        $this->loadViewsFrom(__DIR__.'/Views','payamsms');


        $this->publishes([
            __DIR__.'/Config/main.php'=>config_path('payamsms.php')
        ],'config');

        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/payamsms')
        ],'views');

        $this->publishes([
            __DIR__.'/Migrations' => database_path('/migrations')
        ],'migrations');


    }
}