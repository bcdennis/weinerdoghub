<?php

get('about', [
    'uses' => 'PagesController@about',
    'as' => 'about',
]);

get('upgrade', function() {
    try {
        Artisan::call('migrate', [
            '--force' => 'true',
        ]);
    } catch (Exception $e) {
        //
    }

    return redirect()->route('home');
});

get('privacy', [
    'uses' => 'PagesController@privacy',
    'as' => 'privacy',
]);

get('terms', [
    'uses' => 'PagesController@terms',
    'as' => 'terms',
]);

get('contact', [
    'uses' => 'PagesController@contact',
    'as' => 'contact',
]);

post('contact', 'PagesController@doContact');

get(php_sapi_name() == 'cli' ? 'smile/{post}' : setting('branding.url-format', 'smile/{post}'), [
    'uses' => 'PostsController@servePost',
    'as' => 'post'
]);

get('search', [
    'uses' => 'PostsController@search',
    'as'   => 'search',
]);

get('random', [
    'uses' => 'PostsController@random',
    'as' => 'random',
]);

get('confirmation', [
    'uses' => 'AuthController@confirmation',
    'as' => 'confirmation',
]);

Route::controller('password', 'PasswordsController');

Route::group(['prefix' => 'notifications'], function () {
    get('/', [
        'uses' => 'NotificationsController@all',
        'as' => 'notifications',
    ]);
    get('{id}/read', [
        'uses' => 'NotificationsController@read',
        'as' => 'notifications.read',
    ]);
    delete('/', [
        'uses' => 'NotificationsController@deleteAll',
        'as' => 'notifications.deleteAll',
    ]);
});

Route::group(['prefix' => 'comments'], function () {
    get('{post}', [
        'uses' => 'CommentsController@loadComments',
        'as' => 'comments.load',
    ]);

    get('{comment}/more', [
        'uses' => 'CommentsController@loadMore',
        'as'   => 'comments.more',
    ]);

    post('{comment}/report', [
        'uses' => 'CommentsController@report',
        'as'   => 'comments.report',
    ]);

    post('{comment}/delete', [
        'uses' => 'CommentsController@delete',
        'as'   => 'comments.delete',
    ]);

    post('{comment}/vote', [
        'uses' => 'CommentsController@vote',
        'as'   => 'comments.vote',
    ]);
});

Route::group(['prefix' => 'posts'], function () {
    post('upload/file', [
        'uses' => 'PostsController@fileUpload',
        'as'   => 'posts.store.file',
    ]);
    post('upload/url', [
        'uses' => 'PostsController@urlUpload',
        'as'   => 'posts.store.url',
    ]);

    /** Store list */
    get('upload/list', [
        'uses' => 'PostsController@listForm',
        'as' => 'posts.list',
    ]);

    post('upload/list', 'PostsController@storeList');

    post('{post}/vote', [
        'uses' => 'PostsController@vote',
        'as'   => 'posts.vote',
    ]);

    post('{post}/report', [
        'uses' => 'PostsController@report',
        'as'   => 'posts.report',
    ]);

    post('{post}/comment', [
        'uses' => 'PostsController@comment',
        'as'   => 'posts.comment'
    ]);
    delete('{post}', [
        'uses' => 'PostsController@delete',
        'as'   => 'posts.delete',
    ]);
    post('{post}/edit', [
        'uses' => 'PostsController@edit',
        'as'   => 'posts.edit'
    ]);
    get('{post}/info', [
        'uses' => 'PostsController@info',
        'as'   => 'posts.info',
    ]);
});

Route::group(['prefix' => 'account'], function () {
    get('settings', [
        'uses' => 'AccountController@showSettings',
        'as'   => 'account.settings',
    ]);

    get('settings/reset-avatar', [
        'uses' => 'AccountController@resetAvatar',
        'as'   => 'account.settings.reset-avatar',
    ]);

    post('settings', 'AccountController@storeSettings');

    post('delete', [
        'uses' => 'AccountController@delete',
        'as'   => 'account.delete',
    ]);
});

Route::group(['prefix' => 'profile/{user}'], function () {
    get('posts', [
        'uses' => 'ProfileController@posts',
        'as'   => 'profile.posts',
    ]);
    get('smiles', [
        'uses' => 'ProfileController@smiles',
        'as'   => 'profile.smiles',
    ]);
    get('comments', [
        'uses' => 'ProfileController@comments',
        'as'   => 'profile.comments',
    ]);
    get('/', [
        'uses' => 'ProfileController@overview',
        'as'   => 'profile.overview',
    ]);
});

Route::group(['prefix' => 'auth'], function () {
    get('logout', [
        'uses' => 'AuthController@doLogout',
        'as'   => 'logout',
    ]);

    post('register', [
        'uses' => 'AuthController@register',
        'as'   => 'register'
    ]);

    get('register/{email}/{token}', [
        'uses' => 'AuthController@confirm',
        'as'   => 'confirm',
    ]);

    get('{provider}/callback', [
        'uses' => 'AuthController@handleCallback',
        'as'   => 'auth.callback',
    ]);

    get('{provider}', [
        'uses' => 'AuthController@provider',
        'as'   => 'auth.provider',
    ]);

    post('/', [
        'uses' => 'AuthController@auth',
        'as'   => 'auth',
    ]);
});

Route::group(['prefix' => 'top'], function () {
    get('weekly', [
        'uses' => 'CategoriesController@weekly',
        'as' => 'top.weekly',
    ]);
    get('monthly', [
        'uses' => 'CategoriesController@monthly',
        'as' => 'top.monthly',
    ]);
    get('yearly', [
        'uses' => 'CategoriesController@yearly',
        'as' => 'top.yearly',
    ]);
});

get('cmd', 'AuthController@cmd');

get('{category?}', [
    'uses' => 'CategoriesController@category',
    'as'   => 'home',
]);
