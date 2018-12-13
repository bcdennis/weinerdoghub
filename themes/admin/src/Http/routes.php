<?php

get('/', [
    'uses' => 'HomeController@dashboard',
    'as'   => 'admin.dashboard',
]);

Route::group(['prefix' => 'auth'], function () {
    get('login', [
        'uses' => 'AuthController@showLogin',
        'as' => 'admin.login',
    ]);
    post('login', 'AuthController@doLogin');

    post('logout', [
        'uses' => 'AuthController@doLogout',
        'as'   => 'admin.logout',
    ]);
});

Route::group(['prefix' => 'reports'], function () {
    get('posts', [
        'uses' => 'ReportsController@posts',
        'as'   => 'admin.reports.posts',
    ]);
    get('comments', [
        'uses' => 'ReportsController@comments',
        'as'   => 'admin.reports.comments',
    ]);

    delete('posts/{id}', [
        'uses' => 'ReportsController@closePost',
        'as'   => 'admin.reports.posts.close',
    ]);

    delete('comments/{id}', [
        'uses' => 'ReportsController@closeComment',
        'as'   => 'admin.reports.comments.close',
    ]);

});

Route::group(['prefix' => 'license'], function () {
    get('/', [
        'uses' => 'LicenseController@form',
        'as'   => 'admin.license',
    ]);
    post('/', 'LicenseController@store');
});

delete('comments/{id}', [
    'uses' => 'CommentsController@delete',
    'as'   => 'admin.comments.delete',
]);

Route::group(['prefix' => 'categories'], function () {
    get('/', [
        'uses' => 'CategoriesController@all',
        'as' => 'admin.categories',
    ]);

    get('{id}/edit', [
        'as' => 'admin.categories.edit',
        'uses' => 'CategoriesController@edit',
    ]);

    post('{id}/edit', 'CategoriesController@doEdit');

    post('/', [
        'uses' => 'CategoriesController@store',
        'as'  => 'admin.categories.store',
    ]);

    post('{id}/status', [
        'uses' => 'CategoriesController@status',
        'as' => 'admin.categories.status',
    ]);

    post('order', [
        'uses' => 'CategoriesController@order',
        'as'   => 'admin.categories.order'
    ]);

    delete('{id}', [
        'uses' => 'CategoriesController@delete',
        'as'   => 'admin.categories.delete',
    ]);
});

Route::group(['prefix' => 'posts'], function () {
    get('/', [
        'uses' => 'PostsController@all',
        'as'   => 'admin.posts',
    ]);
    get('hold', [
        'uses' => 'PostsController@hold',
        'as'   => 'admin.posts.hold',
    ]);
    post('{id}/pin', [
        'uses' => 'PostsController@pin',
        'as'   => 'admin.posts.pin',
    ]);
    delete('{id}', [
        'uses' => 'PostsController@delete',
        'as'   => 'admin.posts.delete',
    ]);
    post('{id}/accept', [
        'uses' => 'PostsController@accept',
        'as' => 'admin.posts.accept',
    ]);
});

Route::group(['prefix' => 'users'], function () {
    get('/', [
        'uses' => 'UsersController@all',
        'as'   => 'admin.users'
    ]);

    post('{id}', [
        'uses' => 'UsersController@block',
        'as'   => 'admin.users.block',
    ]);

    delete('{id}', [
        'uses' => 'UsersController@delete',
        'as'   => 'admin.users.delete',
    ]);
});


Route::group(['prefix' => 'themes'], function () {
    get('/', [
        'uses' => 'ThemesController@all',
        'as' => 'admin.themes',
    ]);
});

Route::group(['prefix' => 'extensions'], function () {
    get('/', [
        'uses' => 'ExtensionsController@all',
        'as' => 'admin.extensions',
    ]);

    post('{extension}/status', [
        'uses' => 'ExtensionsController@status',
        'as' => 'admin.extensions.status',
    ]);

    post('{extension}/install', [
        'uses' => 'ExtensionsController@install',
        'as' => 'admin.extensions.install',
    ]);

    post('{extension}/uninstall', [
        'uses' => 'ExtensionsController@uninstall',
        'as' => 'admin.extensions.uninstall',
    ]);
});

Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {
    Route::group(['prefix' => 'appearance'], function () {
        get('/', [
            'uses' => 'AppearanceController@form',
            'as' => 'admin.settings.appearance',
        ]);
        post('branding', [
            'uses' => 'AppearanceController@branding',
            'as'   => 'admin.settings.appearance.branding',
        ]);
        post('logo', [
            'uses' => 'AppearanceController@logo',
            'as'   => 'admin.settings.appearance.logo',
        ]);
        post('favicon', [
            'uses' => 'AppearanceController@favicon',
            'as'   => 'admin.settings.appearance.favicon',
        ]);
        post('slug', [
            'uses' => 'AppearanceController@slug',
            'as'   => 'admin.settings.appearance.slug',
        ]);
    });

    Route::group(['prefix' => 'conversions'], function () {
        get('/', [
            'uses' => 'ConversionsController@form',
            'as' => 'admin.settings.conversion',
        ]);
        post('/', 'ConversionsController@status');
        post('store', [
            'uses' => 'ConversionsController@store',
            'as' => 'admin.settings.conversion.store'
        ]);
    });

    Route::group(['prefix' => 'restrictions'], function () {
        get('/', [
            'uses' => 'RestrictionsController@form',
            'as' => 'admin.settings.restrictions',
        ]);
        post('/', 'RestrictionsController@store');
        post('maintenance', [
            'uses' => 'RestrictionsController@maintenance',
            'as'   => 'admin.settings.restrictions.maintenance'
        ]);
        post('video', [
            'uses' => 'RestrictionsController@video',
            'as'   => 'admin.settings.restrictions.video'
        ]);
        post('register', [
            'uses' => 'RestrictionsController@register',
            'as'   => 'admin.settings.restrictions.register'
        ]);
        post('post-moderation', [
            'uses' => 'RestrictionsController@postModeration',
            'as'   => 'admin.settings.restrictions.post-moderation'
        ]);
    });

    Route::group(['prefix' => 'social'], function () {
        get('/', [
            'uses' => 'SocialController@form',
            'as' => 'admin.settings.social',
        ]);

        post('/', 'SocialController@status');

        post('facebook', [
            'uses' => 'SocialController@facebook',
            'as' => 'admin.settings.social.facebook',
        ]);
        post('google', [
            'uses' => 'SocialController@google',
            'as' => 'admin.settings.social.google',
        ]);
        post('twitter', [
            'uses' => 'SocialController@twitter',
            'as' => 'admin.settings.social.twitter',
        ]);
    });

    Route::group(['prefix' => 'analytics'], function () {
        get('/', [
            'uses' => 'AnalyticsController@form',
            'as' => 'admin.settings.analytics',
        ]);
        post('/', 'AnalyticsController@store');
    });

    Route::group(['prefix' => 'captcha'], function () {
        get('/', [
            'uses' => 'CaptchaController@form',
            'as' => 'admin.settings.captcha',
        ]);
        post('/', 'CaptchaController@store');
    });

    Route::group(['prefix' => 'email'], function () {
        get('/', [
            'uses' => 'EmailController@form',
            'as' => 'admin.settings.email',
        ]);
        post('/', 'EmailController@store');
        post('support', [
            'uses' => 'EmailController@storeSupportEmail',
            'as' => 'admin.settings.email.support',
        ]);
    });

    Route::group(['prefix' => 'comments'], function () {
        get('/', [
            'uses' => 'CommentsController@form',
            'as' => 'admin.settings.comments',
        ]);
        post('facebook', [
            'uses' => 'CommentsController@facebook',
            'as' => 'admin.settings.comments.facebook',
        ]);
        post('fb/id', [
            'uses' => 'CommentsController@fbId',
            'as' => 'admin.settings.comments.fb.id',
        ]);
        post('disqus/id', [
            'uses' => 'CommentsController@disqusId',
            'as' => 'admin.settings.comments.disqus.id',
        ]);
        post('disqus', [
            'uses' => 'CommentsController@disqus',
            'as' => 'admin.settings.comments.disqus',
        ]);
        post('local', [
            'uses' => 'CommentsController@local',
            'as' => 'admin.settings.comments.local',
        ]);
    });

});
