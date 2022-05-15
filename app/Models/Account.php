<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Crypt;

class Account extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';


    const NORMAL = true;
    const ABNORMAL = false;

    public static $status = [
        self::NORMAL => '正常',
        self::ABNORMAL => '异常',
    ];

    public static $statusColor = [
        self::NORMAL => 'success',
        self::ABNORMAL => 'danger',
    ];

    const ANDROID = 'android';
    const IOS = 'ios';

    public static $device = [
        self::ANDROID => '安卓',
        self::IOS => '苹果',
    ];

    public static $deviceColor = [
        self::ANDROID => 'primary',
        self::IOS => 'info',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'device',
        'phone',
        'password',
        'deleted_at',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'device' => 'string',
        'phone' => 'integer',
        'password' => 'string',
        'deleted_at' => 'datetime',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
