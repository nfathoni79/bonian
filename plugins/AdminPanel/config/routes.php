<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute; 
use Cake\Http\Middleware\CsrfProtectionMiddleware;

Router::plugin(
    'AdminPanel',
    ['path' => '/admin-panel'],
    function (RouteBuilder $routes) {
        $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware());
        $routes->applyMiddleware('csrf');
        $routes->connect('/', ['controller' => 'dashboard']);
        $routes->fallbacks(DashedRoute::class);
    }
);
