<?php

namespace Nematollahi\ACL;

use Nematollahi\ACL\Contracts\IACL;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Nematollahi\ACL\Traits\HasACLTools;
use Illuminate\Support\Facades\Config;

class ACL implements IACL
{
    use HasACLTools;
    public static function run() // craete gate 
    {
        $modelPermission = Config::get("acl.permission"); //call class permission
        (new $modelPermission)->all()->map(function ($permission) { // create gate
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        });
    }
}