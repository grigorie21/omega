<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class UserM2mRole extends Model
{
    public $timestamps = false;

    protected $table = 'view_user_m2m_role';
    protected $fillable = [];
}
