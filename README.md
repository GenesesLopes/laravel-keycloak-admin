# Installtion

```
composer require srlopes/laravel-keycloak-admin
```

# laravel-keycloak-admin



Add these environment variables to your .env :


```
KEYCLOAK_ADMIN_BASE_URL=http://keycloak-domain.example/auth

KEYCLOAK_ADMIN_REALM_LOGIN=

KEYCLOAK_ADMIN_REALM=

KEYCLOAK_ADMIN_REALM_PUBLIC_KEY=     # realm settings -> keys 
      
# Choose to fill in user name and password or client_id and client_secret

KEYCLOAK_ADMIN_USERNAME=

KEYCLOAK_ADMIN_PASSWORD=

KEYCLOAK_ADMIN_CLIENT_ID=      

KEYCLOAK_ADMIN_CLIENT_SECRET=        # clients -> your_client -> credentials 

KEYCLOAK_ADMIN_BASE_URL_REALM=${KEYCLOAK_BASE_URL}/admin/realms/${KEYCLOAK_ADMIN_REALM} 
```

# Enable realm managment

Go to ```clients -> your_client -> Service Account``` then select realm-managment

from Client Roles list and assign realm-admin to client.


# available methods : 


Package has provided services as below :

* user
* role
* client
* clientRole


Publish the config file:

````
php artisan vendor:publish --provider="KeycloakAdm\KeycloakAdminServiceProvider"
````


All api's are in ```config\keycloakAdmin.php```
 
For every api just call api name as method on related service .



example:
```php
KeycloakAdmin::serviceName()->apiName($parameters)



keycloakAdmin::user()->create([
      
     'body' => [  // https://www.keycloak.org/docs-api/11.0/rest-api/index.html#_userrepresentation
             
             'username' => 'foo'
              
       ]

]);



keycloakAdmin::user()->update([

     'id' => 'user_id',

     'body' => [  // https://www.keycloak.org/docs-api/11.0/rest-api/index.html#_userrepresentation
             
             'username' => 'foo'
              
       ]

]);



keycloakAdmin::role()->get([
      
     'id' => 'role_id'

]);
```

All other api calls are same as examples just need to see required parameters for every api in https://www.keycloak.org/docs-api/11.0/rest-api/index.html
