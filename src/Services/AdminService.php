<?php

namespace KeycloakAdm\Services;

use KeycloakAdm\Auth\ClientAuthService;
use GuzzleHttp\Client as HttpClient;

class AdminService
{
    /*
     * Holds services
     */
    protected $container = [];



    /*
     * Loads defined services
     */
    function __construct(ClientAuthService $auth) {

        $this->auth = $auth;

        $this->loadServices();

    }


    public function getService(string $service)
    {
          return new $this->container[$service]($this->auth , new HttpClient());
    }


    public function loadServices() : void
    {

        $this->container =[
           'User' => User::class,
           'Role' => Role::class,
           'Client' => Client::class,
           'ClientRole' => ClientRole::class,
           'Group' => Group::class,
        ];

    }


    public function user()
    {
       return $this->getService('User');
    }

    public function role()
    {
        return $this->getService('Role');
    }


    public function client()
    {
        return $this->getService('Client');
    }


    public function clientRole()
    {
        return $this->getService('ClientRole');
    }

    public function group()
    {
        return $this->getService('Group');
    }

}
