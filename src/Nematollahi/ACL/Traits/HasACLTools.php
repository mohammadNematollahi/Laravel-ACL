<?php

namespace Nematollahi\ACL\Traits;

use Illuminate\Support\Facades\Config;

trait HasACLTools
{
    protected array $userPermissions = []; // it stores all the user's permissions in itself (role + permission )

    public function roles() // get all current user roles
    {
        return $this->belongsToMany(Config::get("acl.role"));
    }

    public function permissions() // get all current user roles
    {
        return $this->belongsToMany(Config::get("acl.permission"));
    }

    public function hasRoles(array $roles): bool // bool get all current user roles
    {
        foreach ($roles as $role) {
            if ($this->roles->contains("name", $role)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($permission): bool // this method checks whether the user currently has the permissions
    {
        $accessPermission = $this->setPermissions();
        if (in_array($permission, $accessPermission)) {
            return true;
        }

        return false;
    }
    protected function setPermissions(): array // initializes the userPermissions variable
    {
        //we put a loop on all the user roles and put all the permissions that exist in it into the userPermissions variable
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                array_push($this->userPermissions, $permission->name);
            }
        }

        //we put all permissions in the userPermissions variable
        foreach ($this->permissions as $permission) {
            array_push($this->userPermissions, $permission->name);
        }

        return $this->userPermissions;
    }
}