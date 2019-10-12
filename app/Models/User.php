<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;

    protected $table = 'user';
    protected $fillable = [
        'full_name',
        'birthday_date',
        'organization',
        'user_type_id'
        ];

    public function userM2mRole() {
        return $this->hasMany(UserM2MRole::class, 'user_id', 'id');
    }

    public function userType() {
//        return $this->belongsTo(UserType::class, 'user_type_id', 'id');
        return $this->belongsTo(UserType::class);
    }
}
