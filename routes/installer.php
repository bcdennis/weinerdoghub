<?php

use Illuminate\Routing\Router;

Route::group([], function (Router $router) {
    $router->get('/', 'HomeController@getStarted')->name('license');
    $router->post('/', 'HomeController@store');
    $router->get('/requirements', 'RequirementsController@page')->name('requirements');
    $router->get('/database', 'DatabaseController@page')->name('database');
    $router->post('/database/check', 'DatabaseController@check')->name('database.check');
    $router->get('/email', 'EmailController@page')->name('email');
    $router->post('/email', 'EmailController@save');
    $router->get('/admin', 'AdminController@page')->name('admin');
    $router->post('/admin', 'AdminController@save');
    $router->get('/finish', 'FinishController@page')->name('finish');
    $router->post('/finish', 'FinishController@save');
});
