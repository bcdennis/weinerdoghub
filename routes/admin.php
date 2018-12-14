<?php

use Illuminate\Routing\Router;

Route::group([], function (Router $router) {
    $router->get('/', 'HomeController@dashboard')->name('admin.dashboard');

    $router->group(['prefix' => '/auth'], function (Router $router) {
        $router->get('/login', 'AuthController@showLogin')->name('admin.login');
        $router->post('/login', 'AuthController@doLogin');
        $router->post('/logout', 'AuthController@doLogout')->name('admin.logout');
    });

    $router->group(['prefix' => '/reports'], function (Router $router) {
        $router->get('/posts', 'ReportsController@posts')->name('admin.reports.posts');
        $router->get('/comments', 'ReportsController@comments')->name('admin.reports.comments');
        $router->delete('/posts/{id}', 'ReportsController@closePost')->name('admin.reports.posts.close');
        $router->delete('/comments/{id}', 'ReportsController@closeComment')->name('admin.reports.comments.close');
    });

    $router->group(['prefix' => '/license'], function (Router $router) {
        $router->get('/', 'LicenseController@form')->name('admin.license');
        $router->post('/', 'LicenseController@store');
    });

    $router->delete('/comments/{id}', 'CommentsController@delete')->name('admin.comments.delete');

    $router->group(['prefix' => '/categories'], function (Router $router) {
        $router->get('/', 'CategoriesController@all')->name('admin.categories');
        $router->get('/{id}/edit', 'CategoriesController@edit')->name('admin.categories.edit');
        $router->post('/{id}/edit', 'CategoriesController@doEdit');
        $router->post('/', 'CategoriesController@store')->name('admin.categories.store');
        $router->post('/{id}/status', 'CategoriesController@status')->name('admin.categories.status');
        $router->post('/order', 'CategoriesController@order')->name('admin.categories.order');
        $router->delete('/{id}', 'CategoriesController@delete')->name('admin.categories.delete');
    });

    $router->group(['prefix' => 'posts'], function (Router $router) {
        $router->get('/', 'PostsController@all')->name('admin.posts');
        $router->get('hold', 'PostsController@hold')->name('admin.posts.hold');
        $router->post('{id}/pin', 'PostsController@pin')->name('admin.posts.pin');
        $router->delete('{id}', 'PostsController@delete')->name('admin.posts.delete');
        $router->post('{id}/accept', 'PostsController@accept')->name('admin.posts.accept');
    });

    $router->group(['prefix' => 'users'], function (Router $router) {
        $router->get('/', 'UsersController@all')->name('admin.users');
        $router->post('{id}', 'UsersController@block')->name('admin.users.block');
        $router->delete('{id}', 'UsersController@delete')->name('admin.users.delete');
    });

    $router->group(['prefix' => 'extensions'], function (Router $router) {
        $router->get('/', 'ExtensionsController@all')->name('admin.extensions');
        $router->post('{extension}/status', 'ExtensionsController@status')->name('admin.extensions.status');
        $router->post('{extension}/install', 'ExtensionsController@install')->name('admin.extensions.install');
        $router->post('{extension}/uninstall', 'ExtensionsController@uninstall')->name('admin.extensions.uninstall');
    });

    $router->group(['namespace' => 'Settings', 'prefix' => 'settings'], function (Router $router) {
        $router->group(['prefix' => 'appearance'], function (Router $router) {
            $router->get('/', 'AppearanceController@form')->name('admin.settings.appearance');
            $router->post('branding', 'AppearanceController@branding')->name('admin.settings.appearance.branding');
            $router->post('logo', 'AppearanceController@logo')->name('admin.settings.appearance.logo');
            $router->post('favicon', 'AppearanceController@favicon')->name('admin.settings.appearance.favicon');
            $router->post('slug', 'AppearanceController@slug')->name('admin.settings.appearance.slug');
        });

        $router->group(['prefix' => 'conversions'], function (Router $router) {
            $router->get('/', 'ConversionsController@form')->name('admin.settings.conversion');
            $router->post('/', 'ConversionsController@status');
            $router->post('store', 'ConversionsController@store')->name('admin.settings.conversion.store');
        });

        $router->group(['prefix' => 'restrictions'], function (Router $router) {
            $router->get('/', 'RestrictionsController@form')->name('admin.settings.restrictions');
            $router->post('/', 'RestrictionsController@store');
            $router->post('maintenance', 'RestrictionsController@maintenance')->name('admin.settings.restrictions.maintenance');
            $router->post('video', 'RestrictionsController@video')->name('admin.settings.restrictions.video');
            $router->post('register', 'RestrictionsController@register')->name('admin.settings.restrictions.register');
            $router->post('post-moderation', 'RestrictionsController@postModeration')->name('admin.settings.restrictions.post-moderation');
        });

        $router->group(['prefix' => 'social'], function (Router $router) {
            $router->get('/', 'SocialController@form')->name('admin.settings.social');
            $router->post('/', 'SocialController@status');
            $router->post('facebook', 'SocialController@facebook')->name('admin.settings.social.facebook');
            $router->post('google', 'SocialController@google')->name('admin.settings.social.google');
            $router->post('twitter', 'SocialController@twitter')->name('admin.settings.social.twitter');
        });

        $router->group(['prefix' => 'analytics'], function (Router $router) {
            $router->get('/', 'AnalyticsController@form')->name('admin.settings.analytics');
            $router->post('/', 'AnalyticsController@store');
        });

        $router->group(['prefix' => 'captcha'], function (Router $router) {
            $router->get('/', 'CaptchaController@form')->name('admin.settings.captcha');
            $router->post('/', 'CaptchaController@store');
        });

        $router->group(['prefix' => 'email'], function (Router $router) {
            $router->get('/', 'EmailController@form')->name('admin.settings.email');
            $router->post('/', 'EmailController@store');
            $router->post('support', 'EmailController@storeSupportEmail')->name('admin.settings.email.support');
        });

        $router->group(['prefix' => 'comments'], function (Router $router) {
            $router->get('/', 'CommentsController@form')->name('admin.settings.comments');
            $router->post('facebook', 'CommentsController@facebook')->name('admin.settings.comments.facebook');
            $router->post('fb/id', 'CommentsController@fbId')->name('admin.settings.comments.fb.id');
            $router->post('disqus/id', 'CommentsController@disqusId')->name('admin.settings.comments.disqus.id');
            $router->post('disqus', 'CommentsController@disqus')->name('admin.settings.comments.disqus');
            $router->post('local', 'CommentsController@local')->name('admin.settings.comments.local');
        });

    });
});
