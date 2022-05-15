<?php

namespace App\Models;

class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    const START = 'START';
    const END = 'END';

    public static $type = [
        self::START => '上班',
        self::END => '下班',
    ];

    public static $typeColor = [
        self::START => 'primary',
        self::END => 'info',
    ];

    const ENABLE = true;
    const DISABLE = false;

    public static $status = [
        self::ENABLE => '启用',
        self::DISABLE => '禁用',
    ];

    public static $statusColor = [
        self::ENABLE => 'primary',
        self::DISABLE => 'danger',
    ];

    const DAILY = 'daily';

    public static $role = [
        self::DAILY => '每天',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'account_id',
        'address_id',
        'type',
        'run',
        'description',
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
        'account_id' => 'integer',
        'address_id' => 'integer',
        'type' => 'string',
        'run' => 'json',
        'description' => 'string',
        'status' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
