<?php

namespace KeycloakAdm\Services;

use KeycloakAdm\Auth\ClientAuthService;
use KeycloakAdm\Services\Traits\HasApi;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Arr;

class Role
{

    use HasApi;

    /*
     * Api uri's
     */
    protected $api = [];

    /*
     * Http client
     */
    protected $http;

    /*
     * Client authorization service
     */
    protected $auth;


    function __construct(ClientAuthService $auth, ClientInterface $http)
    {

        $this->auth = $auth;
        $this->http = $http;
        $this->api = config('keycloakAdmin.api.role');
    }


    public function __call($api, $args)
    {

        $args = Arr::collapse($args);

        list($url, $method) = $this->getApi($api, $args);

        $response = $this
            ->http
            ->request($method, $url, $this->createOptions($args));

        return $this->response($response);
    }



    /**
     * Creates guzzle http clinet options
     * @param array|null $params
     * @return array
     */

    public function createOptions(array $params = null): array
    {
        return  [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->auth->getToken(),
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Accept, Authorization, X-Requested-With, Application'
            ],
            'json' => $params['body'] ?? null,
        ];
    }


    /**
     * return appropriate response
     */

    public function response($response)
    {
        if (!empty($location = $response->getHeader('location'))) {

            $url = current($location);

            return $this->getByName([
                'role' => substr($url, strrpos($url, '/') + 1)
            ]);
        }

        return json_decode($response->getBody()->getContents(), true) ?: true;
    }
}
