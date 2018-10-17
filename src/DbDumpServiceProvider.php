<?php

namespace iJiabao\DbDump;

use iJiabao\DbDump\Console\Commands\DbDumpCommand;
use Illuminate\Support\ServiceProvider;

class DbDumpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'/../config/dbdump.php' => config_path('dbdump.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(
            __DIR__.'/../config/dbdump.php', 'dbdump'
        );

        $this->app->singleton('command.ijiabao.dbdump',  function ($app) {
            return new DbDumpCommand();
        });

        $this->app->singleton('ijiabao.dbdump', function($app){
            return new DbDump();
        });

        $this->commands('command.ijiabao.dbdump');
    }
}
