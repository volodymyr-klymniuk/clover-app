<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->group([ 'prefix' => 'api/', ],
    function () use ($router) {
        $router->group(['prefix' => 'user/'], function () use ($router) {
                $router->post('register', [ 'uses' => 'RegisterController@register', ],);
                $router->post('sign-in', [ 'uses' => 'AuthController@signIn', ],);
                $router->post('recover-password', [ 'uses' => 'RecoverController@createRecoverRequest', ],);
                $router->patch('recover-password', [ 'uses' => 'RecoverController@updateRecoverRequest', ],);
                $router->get('companies', [ 'middleware' => 'auth', 'uses' => 'CompaniesController@getCompanies', ]);
                $router->post('companies', [ 'middleware' => 'auth', 'uses' => 'CompaniesController@createCompany', ]);
            }
        );
    }
);
