<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        'is_admin',
        'deleted_at',
        'active',
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
        'is_admin' => 'boolean',
        'deleted_at' => 'datetime',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'slug',
    ];

    public function slug(): string
    {
        return $this->isAdministrator() ? '管理员' : '普通用户';
    }

    public function password(): Attribute
    {
        return Attribute::set(function (string $password) {
            if (password_get_info($password)['algoName'] !== 'bcrypt') {
                $password = Hash::make($password);
            }

            return $password;
        });
    }

    public function gravatar(int $size = 100): string
    {
//        $hash = md5($this->email);
//        return "https://www.gravatar.com/avatar/{$hash}?s={$size}";

        return 'https://cdn.acewangpai.com/avatars/laradocs.png';
    }

    public function avatar(): Attribute
    {
        return Attribute::get(function (string $avatar) {
            if (empty($avatar)) {
                return $this->gravatar();
            }

            return $avatar;
        });
    }

    public function scopeIsAdministrator(): bool
    {
        return $this->is_admin ? true : false;
    }
}
