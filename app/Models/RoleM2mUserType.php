<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleM2mUserType extends Model
{
    public $timestamps = false;

    protected $table = 'role_m2m_user_type';
    protected $fillable = [
        'user_id',
        'role_id'
    ];

//    public function order() {
//        return $this->hasMany(\App\Models\Order::class, 'user_id', 'id');
//    }
}
