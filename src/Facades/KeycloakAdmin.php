<?php

namespace KeycloakAdm\Facades;

use Illuminate\Support\Facades\Facade;


class KeycloakAdmin extends Facade
{



    protected static function getFacadeAccessor(){

          return 'KeycloakAdmin';

    }


}