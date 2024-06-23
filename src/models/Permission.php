<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $fillable = ["name" , "description" , "status"];

    public function roles()
    {
        return $this->belongsToMany(Role::class , "permission_role" , "permission_id" , "role_id");
    }
}
