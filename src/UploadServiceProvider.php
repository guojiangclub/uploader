<?php

namespace iBrand\Upload;

use iBrand\Upload\Checkers\ImageChecker;
use iBrand\Upload\Checkers\VideoChecker;
use iBrand\Upload\Checkers\VoiceChecker;
use Illuminate\Support\ServiceProvider;
use Route;

class UploadServiceProvider extends ServiceProvider
{
    protected $namespace = 'iBrand\Upload';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/config.php' => config_path('ibrand/uploader.php')], 'config');

            $this->publishes([__DIR__ . '/../migrations/' => database_path('migrations')], 'migrations');
        }

        $this->registerMigrations();

        $this->map();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'ibrand.uploader'
        );

        $filesystems = $this->app['config']->get('filesystems.disks', []);

        $this->app['config']->set('filesystems.disks', array_merge($filesystems, config('ibrand.uploader.disks')));

        $this->app->alias(ImageChecker::class, ImageChecker::TYPE);
        $this->app->alias(VideoChecker::class, VideoChecker::TYPE);
        $this->app->alias(VoiceChecker::class, VoiceChecker::TYPE);
    }

    public function map()
    {
        Route::group(['namespace' => $this->namespace], function ($router) {
            $router->post('cdn/upload', 'UploadController@upload')->name('cdn.qiniu.upload');
        });
    }

    public function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }
}