<?php

namespace Dashboard\RevDB\Config;


/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */ 

$routes->group('revenueMaster', ['namespace' => 'Dashboard\RevDB\Controllers'], static function ($routes) {
    // Manage districts  http://localhost/revenueMaster/districts?page=3
	
    $routes->match(['get', 'post'], 'districts', 'RevenueMasterController::listd', ['as' => 'district-list']);
    $routes->get('districts/created', 'RevenueMasterController::created', ['as' => 'district-new']);
    $routes->get('districts/(:num)', 'RevenueMasterController::editd/$1', ['as' => 'district-edit']);
    $routes->get('districts/(:num)/delete', 'RevenueMasterController::deleted/$1', ['as' => 'district-delete']);
    $routes->post('districts/(:num)/save', 'RevenueMasterController::saved/$1', ['as' => 'district-save']);
    $routes->post('districts/saved', 'RevenueMasterController::saved');
    $routes->post('districts/delete-batchd', 'RevenueMasterController::deleteBatchd');
});

?>