<?php

namespace Dashboard\Portal\Config;


/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */

$routes->group('public', ['namespace' => 'Dashboard\Portal\Controllers'], static function ($routes) {
    $routes->match(['get', 'post'], 'home', 'PublicController::index');
});

?>
