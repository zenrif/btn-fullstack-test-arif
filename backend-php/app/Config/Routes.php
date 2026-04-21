<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Auth::loginForm');

$routes->get('login',   'Auth::loginForm',    ['as' => 'login']);
$routes->post('login',  'Auth::loginProcess', ['as' => 'login.process']);
$routes->get('logout',  'Auth::logout',       ['as' => 'logout']);

$routes->group('product', ['filter' => 'auth'], function ($routes) {
    $routes->get('/',              'Product::index',  ['as' => 'product.index']);
    $routes->get('create',         'Product::create', ['as' => 'product.create']);
    $routes->post('store',         'Product::store',  ['as' => 'product.store']);
    $routes->get('edit/(:num)',    'Product::edit/$1',   ['as' => 'product.edit']);
    $routes->put('update/(:num)', 'Product::update/$1', ['as' => 'product.update']);
    $routes->delete('delete/(:num)', 'Product::delete/$1', ['as' => 'product.delete']);
});
