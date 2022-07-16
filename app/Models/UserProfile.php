<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    public $table = "users_profile";

    protected $fillable = [
        'user_id',
        'country_id',
        'province_id',
        'city',
        'postal_code',
        'photo',
    ];
}
