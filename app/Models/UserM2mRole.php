<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserM2MRole extends Model
{
    public $timestamps = false;

    protected $table = 'user_m2m_role';
    protected $fillable = [
        'user_id', 'role_id'
        ];

    public function user() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
    public function role() {
        return $this->belongsTo(Role::class, 'id', 'role_id');
    }
}
