<?php

namespace App\Models;

class Address extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'province',
        'city',
        'address',
        'longitude',
        'latitude',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'province' => 'string',
        'city' => 'string',
        'address' => 'string',
        'longitude' => 'float',
        'latitude' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getFullAddressAttribute()
    {
        return sprintf ( '%s %s %s', $this->province, $this->city, $this->address );
    }

    public function user()
    {
        return $this->belongsTo ( User::class, 'user_id', 'id' );
    }

    public function tasks()
    {
        return $this->hasMany ( Task::class, 'address_id', 'id' );
    }

    public function authorize ( int $userId )
    {
        return $this->user_id === $userId;
    }
}
