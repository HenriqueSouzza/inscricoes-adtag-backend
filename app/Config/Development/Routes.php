<?php

/**
 * @var \CodeIgniter\Router\RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes)
{
    $routes->resource('pessoa');
});