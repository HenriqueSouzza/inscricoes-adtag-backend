<?php

/**
 * @var \CodeIgniter\Router\RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes)
{
    $routes->resource('pessoa');

    $routes->post('pessoa/resetar-senha', 'Pessoa::resetPassword');
    
    $routes->post('usuario/login', 'Usuario::authenticate');
});
