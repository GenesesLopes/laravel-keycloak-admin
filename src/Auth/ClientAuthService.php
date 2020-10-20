<?php

namespace KeycloakAdm\Auth;


use GuzzleHttp\Client;

class ClientAuthService
{


    protected $client;


    public function __construct()
    {

        $this->client = new Client();
    }


    public function getToken()
    {

        return $this->getAuthorizationToken()['access_token'];
    }


    public function getAuthorizationToken(): array
    {

        $api = config('keycloakAdmin.api.client.token');

        $response = $this->client->post($api, $this->getOptions());

        $this->saveCredentials($credentials = json_decode($response->getBody()->getContents(), true));

        return $credentials;
    }


    public function getOptions()
    {
        if (!is_null(config('keycloakAdmin.client.secret'))) {
            $form_params = [
                'grant_type' => 'client_credentials',
                'client_id' => config('keycloakAdmin.client.id'),
                'client_secret' => config('keycloakAdmin.client.secret'),
            ];
        } else {
            $form_params = [
                'grant_type' => 'password',
                'client_id' => 'admin-cli',
                'username' => config('keycloakAdmin.client.username'),
                'password' => config('keycloakAdmin.client.password'),
            ];
        }
        return [

            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Accept, Authorization, X-Requested-With, Application'
            ],
            'form_params' => $form_params

        ];
    }


    /*
     * save client credentials in a session
     */
    public function saveCredentials($credentials)
    {
        /*
         * set session lifetime based on token expire time dynamically
         */
        Config([
            'session.lifetime' => $credentials['expires_in'] / 60
        ]);

        session(['keycloak.client.auth' => $credentials]);

        session()->save();
    }
}
