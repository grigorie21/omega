<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class RoleM2mUserType extends Model
{
    public $timestamps = false;

    protected $table = 'view_role_m2m_user_type';
    protected $fillable = [];
}
