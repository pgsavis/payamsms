<?php
/**
 * Created by PhpStorm.
 * User: Jamal
 * Date: 9/20/2018
 * Time: 7:23 PM
 */

namespace pgsavis\payamsms;


use Illuminate\Support\Facades\Facade;

class payamsmsFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'payamsms';
    }
}