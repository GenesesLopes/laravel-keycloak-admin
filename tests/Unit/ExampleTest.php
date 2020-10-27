<?php

namespace KeycloakAdm\Tests;

use PHPUnit\Framework\TestCase;

use Illuminate\Support\Facades\Facade;

use KeycloakAdm\Facades\KeycloakAdmin;

class StackTest extends TestCase
{
    public function testPushAndPop()
    {
        KeycloakAdmin::user()->all();
    }
}