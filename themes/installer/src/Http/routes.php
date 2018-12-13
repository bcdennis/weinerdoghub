<?php

get('/', [
    'uses' => 'HomeController@getStarted',
    'as'   => 'home',
]);

get('/', [
    'uses' => 'HomeController@getStarted',
    'as'   => 'license',
]);

post('/', 'HomeController@store');

get('requirements', [
    'uses' => 'RequirementsController@page',
    'as'   => 'requirements',
]);

get('database', [
    'uses' => 'DatabaseController@page',
    'as'   => 'database',
]);

post('database/check', [
    'uses' => 'DatabaseController@check',
    'as'   => 'database.check',
]);

get('email', [
    'uses' => 'EmailController@page',
    'as'   => 'email',
]);

post('email', 'EmailController@save');

get('admin', [
    'uses' => 'AdminController@page',
    'as'   => 'admin',
]);

post('admin', 'AdminController@save');

get('finish', [
    'uses' => 'FinishController@page',
    'as'   => 'finish',
]);

post('finish', 'FinishController@save');
