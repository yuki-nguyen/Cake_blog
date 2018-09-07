<?php


use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;


Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
   
    // $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    $routes->connect('/', ['controller' => 'Articles', 'action' => 'index']);


    $routes->connect(
        '/articles/:id',
        ['controller' => 'Articles', 'action' => 'view']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);

    $routes->connect('/register', ['controller' => 'Users', 'action' => 'add']);


    $routes->fallbacks(DashedRoute::class);
});
