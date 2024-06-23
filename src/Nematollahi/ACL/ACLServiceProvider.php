<?php

namespace Nematollahi\ACL;

use Illuminate\Support\ServiceProvider;

class ACLServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish migrations
        $this->publishes([
            __DIR__ . "/../../migrations/" => database_path('migrations'),
        ], 'acl-migrations');

        // Publish models
        $this->publishes([
            __DIR__ . "/../../models/" => app_path('Models'),
        ], 'acl-models');

        // Publish config file
        $this->publishes([
            __DIR__ . '/../../config/acl.php' => config_path('acl.php'),
        ], 'acl-config');

        // Publish middelware
        $this->publishes([
            __DIR__ . "/../../middleware/" => app_path('Http/Middleware'),
        ], 'acl-models');
    }

    public function register()
    {
        //
    }
}
