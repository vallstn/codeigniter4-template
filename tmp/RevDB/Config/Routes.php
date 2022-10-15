<?php

namespace Dashboard\RevDB\Config;

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group('revenueMaster', ['namespace' => 'Dashboard\RevDB\Controllers'], static function ($routes) {
    $routes->match(['get', 'post'], 'district/district-list(:any)', 'RevenueMasterController::district', ['as' => 'district-list(:any)']);
    $routes->match(['get', 'post'], 'district/getAllDistrict/(:any)', 'RevenueMasterController::getAllDistrict', ['as' => 'getAllDistrict/(:any)']);
    $routes->post('district/ServersideDistrict/(:any)', 'RevenueMasterController::ServersideDistrict', ['as' => 'ServersideDistrict']);
    
    $routes->post('district', 'RevenueMasterController::saveIndex');

});

?>