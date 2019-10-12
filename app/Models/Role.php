<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $table = 'role';
    protected $fillable = [];

    public function userM2mRole() {
        return $this->hasMany(UserM2MRole::class, 'role_id', 'id');
    }

    public function roleM2mUserType() {
        return $this->hasMany(RoleM2mUserType::class, 'role_id', 'id');
    }


}
