<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ["name" , "description" , "status"];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class , "permission_role" , "role_id" , "permission_id");
    }
    
}
