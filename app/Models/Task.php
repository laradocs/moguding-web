<?php

namespace App\Models;

class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'takes';

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
        'run_time',
        'description',
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
        'account_id' => 'integer',
        'user_id' => 'integer',
        'address_id' => 'integer',
        'type' => 'string',
        'run_time' => 'json',
        'description' => 'string',
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo ( User::class, 'user_id', 'id' );
    }

    public function account()
    {
        return $this->belongsTo ( Account::class, 'account_id', 'id' );
    }

    public function address()
    {
        return $this->belongsTo ( Address::class, 'address_id', 'id' );
    }
}
