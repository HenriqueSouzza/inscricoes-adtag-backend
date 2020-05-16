<?php

/**
 * @var \CodeIgniter\Router\RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes)
{
    $routes->resource('pessoa');

    $routes->resource('congregacao');
    
    $routes->resource('evento');

    $routes->resource('inscricao');

    $routes->post('pessoa/resetar-senha', 'Pessoa::resetPassword');
    
    $routes->post('usuario/login', 'Usuario::authenticate');
});
