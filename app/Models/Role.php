<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'roles';
    protected $guarded = ['id'];

    public function permission(){
        return $this->belongsToMany(Permission::class,RolePermission::class , 'role_id','permission_id');
    }
    public function rolePermission(){
        return $this->belongsToMany(Permission::class,RolePermission::class , 'role_id','permission_id')->select('code');
    }
}
