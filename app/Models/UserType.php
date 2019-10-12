<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = true;

    protected $table = 'user_type';
    protected $fillable = [];

    public function user() {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
