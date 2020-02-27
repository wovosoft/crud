<?php

namespace Wovosoft\Crud;

use Wovosoft\Crud\Commands\CrudCommand;
use Wovosoft\Crud\Commands\MakeController;
use Wovosoft\Crud\Commands\MakeModel;
use Wovosoft\Crud\Commands\PackageNew;
use Wovosoft\Crud\Commands\PackageRemove;
use Wovosoft\Crud\Commands\RemoveController;
use Wovosoft\Crud\Commands\RemoveModel;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/wovosoft-crud.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('wovosoft-crud.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PackageNew::class,
                PackageRemove::class,
                MakeModel::class,
                RemoveModel::class,
                MakeController::class,
                RemoveController::class,
                CrudCommand::class
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'wovosoft-crud'
        );
    }
}
