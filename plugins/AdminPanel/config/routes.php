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
        $routes->connect('/', ['controller' => 'Dashboard']);

        //$routes->connect('/reports/review', ['controller' => 'Reports', 'action' => 'review']);
        //$routes->connect('/reports/list-review/*', ['controller' => 'Reports', 'action' => 'listReview']);

        $routes->prefix('report', function (RouteBuilder $routes) {



            // Register scoped middleware for in scopes.
            //$routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            //    'httpOnly' => true
            //]));

            /**
             * Apply a middleware to the current route scope.
             * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
             */
            //$routes->applyMiddleware('csrf');


            //$routes->connect('/:controller');
            //$routes->connect('/:controller/:action');
            //$routes->connect('/:controller/:action/*');

            $routes->fallbacks(DashedRoute::class);
        });


        $routes->fallbacks(DashedRoute::class);
    }
);


