<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_last_name',
        'user_first_name',
        'user_middle_name',
        'user_contact_no',
        'email',
        'user_employee_id',
        'username',
        'role',
        'user_service_provider',
        'password',
        'is_active',
        'user_region',
        'user_province',
        'user_municipality',
        'user_barangay',
    ];

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /*
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /*
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
