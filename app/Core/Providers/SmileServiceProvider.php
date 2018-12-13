<?php
namespace Smile\Core\Providers;

use Illuminate\Support\ServiceProvider;

class SmileServiceProvider extends ServiceProvider {

    /**
     * Database driver
     *
     * @var string
     */
    protected $driver = 'Eloquent';

    /**
     * Repositories that should be registered
     *
     * @var array
     */
    protected $repositories = [
        'Post', 'Comment', 'Category', 'User',
        'OAuthIdentity', 'Vote', 'Activity',
        'PostReport', 'CommentReport', 'Stat', 'Notification',
    ];

    /**
     * Register a new manager that will be used by the core and modules
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Smile\Core\Contracts\Image\UploaderContract',
            'Smile\Core\Image\Uploader'
        );

        $this->app->singleton(
            'Smile\Core\Contracts\Embed\ManagerContract',
            'Smile\Core\Embed\Manager'
        );

        foreach ($this->repositories as $repository) {
            $this->registerRepository($this->driver, $repository);
        }
    }

    /**
     * Register a new repository
     *
     * @param $driver
     * @param $name
     */
    protected function registerRepository($driver, $name)
    {
        $this->app->bind(
            sprintf('Smile\Core\Persistence\Repositories\%sContract', $name),
            sprintf('Smile\Core\Persistence\Repositories\%s\%sRepository', $driver, $name)
        );
    }

}
