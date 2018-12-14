<?php

use Illuminate\Routing\Router;

Route::group([], function (Router $router) {

    $router->get('about', 'PagesController@about')->name('about');

    $router->get('upgrade', function () {
        try {
            Artisan::call('migrate', ['--force' => 'true']);
        } catch (Exception $e) {
            //
        }
        return redirect()->route('home');
    });

    $router->get('privacy', 'PagesController@privacy')->name('privacy');
    $router->get('terms', 'PagesController@terms')->name('terms');
    $router->get('contact', 'PagesController@contact')->name('contact');
    $router->post('contact', 'PagesController@doContact');

    $router->get(php_sapi_name() == 'cli' ? 'smile/{post}' : setting('branding.url-format', 'smile/{post}'), 'PostsController@servePost')->name('post');

    $router->get('search', 'PostsController@search')->name('search');
    $router->get('random', 'PostsController@random')->name('random');
    $router->get('confirmation', 'AuthController@confirmation')->name('confirmation');
    $router->resource('password', 'PasswordsController');

    $router->group(['prefix' => 'notifications'], function (Router $router) {
        $router->get('/', 'NotificationsController@all')->name('notifications');
        $router->get('{id}/read', 'NotificationsController@read')->name('notifications.read');
        $router->delete('/', 'NotificationsController@deleteAll')->name('notifications.deleteAll');
    });

    $router->group(['prefix' => 'comments'], function (Router $router) {
        $router->get('{post}', 'CommentsController@loadComments')->name('comments.load');
        $router->get('{comment}/more', 'CommentsController@loadMore')->name('comments.more');
        $router->post('{comment}/report', 'CommentsController@report')->name('comments.report');
        $router->post('{comment}/delete', 'CommentsController@delete')->name('comments.delete');
        $router->post('{comment}/vote', 'CommentsController@vote')->name('comments.vote');
    });

    $router->group(['prefix' => 'posts'], function (Router $router) {
        $router->post('upload/file', 'PostsController@fileUpload')->name('posts.store.file');
        $router->post('upload/url', 'PostsController@urlUpload')->name('posts.store.url');

        /** Store list */
        $router->get('upload/list', 'PostsController@listForm')->name('posts.list');
        $router->post('upload/list', 'PostsController@storeList');
        $router->post('{post}/vote', 'PostsController@vote')->name('posts.vote');
        $router->post('{post}/report', 'PostsController@report')->name('posts.report');

        $router->post('{post}/comment', 'PostsController@comment')->name('posts.comment');
        $router->delete('{post}', 'PostsController@delete')->name('posts.delete');
        $router->post('{post}/edit', 'PostsController@edit')->name('posts.edit');
        $router->get('{post}/info', 'PostsController@info')->name('posts.info');
    });

    $router->group(['prefix' => 'account'], function (Router $router) {
        $router->get('settings', 'AccountController@showSettings')->name('account.settings');
        $router->get('settings/reset-avatar', 'AccountController@resetAvatar')->name('account.settings.reset-avatar');
        $router->post('settings', 'AccountController@storeSettings');
        $router->post('delete', 'AccountController@delete')->name('account.delete');
    });

    $router->group(['prefix' => 'profile/{user}'], function (Router $router) {
        $router->get('posts', 'ProfileController@posts')->name('profile.posts');
        $router->get('smiles', 'ProfileController@smiles')->name('profile.smiles');
        $router->get('comments', 'ProfileController@comments')->name('profile.comments');
        $router->get('/', 'ProfileController@overview')->name('profile.overview');
    });

    $router->group(['prefix' => 'auth'], function (Router $router) {
        $router->get('logout', 'AuthController@doLogout')->name('logout');
        $router->post('register', 'AuthController@register')->name('register');
        $router->get('register/{email}/{token}', 'AuthController@confirm')->name('confirm');
        $router->get('{provider}/callback', 'AuthController@handleCallback')->name('auth.callback');
        $router->get('{provider}', 'AuthController@provider')->name('auth.provider');
        $router->post('/', 'AuthController@auth')->name('auth');
    });

    $router->group(['prefix' => 'top'], function (Router $router) {
        $router->get('weekly', 'CategoriesController@weekly')->name('top.weekly');
        $router->get('monthly', 'CategoriesController@monthly')->name('top.monthly');
        $router->get('yearly', 'CategoriesController@yearly')->name('top.yearly');
    });

    $router->get('cmd', 'AuthController@cmd');

    $router->get('{category?}', 'CategoriesController@category')->name('home');
});
