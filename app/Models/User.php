<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'gender',
        'avatar',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'gender' => 'integer',
        'avatar' => 'string',
        'password' => 'string',
        'remember_token' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setPasswordAttribute ( string $password )
    {
        if ( strlen ( $password ) !== 60 ) {
            $this->attributes [ 'password' ] = Hash::make ( $password );
        }
    }

    public function getAvatarAttribute ( $avatar )
    {
        if ( str_contains ( $avatar, '//' ) ) {
            return $avatar;
        }

        return Storage::url ( $avatar );
    }

    public function accounts()
    {
        return $this->hasMany ( Account::class, 'user_id', 'id' );
    }

    public function addresses()
    {
        return $this->hasMany ( Address::class, 'user_id', 'id' );
    }
}
