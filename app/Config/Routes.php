<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Authentication Routes that override Shield's
$routes->group('', ['namespace' => 'App\Controllers\Auth'], static function ($routes) {
    $routes->get('register', 'RegisterController::registerView');
    $routes->post('register', 'RegisterController::registerAction');
    $routes->get('login', 'LoginController::loginView');
    $routes->post('login', 'LoginController::loginAction');
    $routes->get('login/magic-link', 'MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', 'MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', 'MagicLinkController::verify', ['as' => 'verify-magic-link']);
	
	$routes->get('captcha/(:segment)', 'LoginController::captcha/$1');
    $routes->get('refreshCaptcha', 'LoginController::refreshCaptcha');
});

$routes->group('', ['namespace' => '\CodeIgniter\Shield\Controllers'], static function ($routes) {
    $routes->get('auth/a/show', 'ActionController::show', ['as' => 'auth-action-show']);
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);

// Download Routes
$routes->group('', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('resource/(:segment)', 'DownloadController::resource/$1');
	$routes->get('css/(:segment)', 'DownloadController::resourcecss/$1');
	$routes->get('svg/(:segment)', 'DownloadController::resourcesvg/$1');
});