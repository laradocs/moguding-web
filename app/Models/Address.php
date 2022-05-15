<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'deleted_at',
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
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'full_address' => 'string',
    ];

    protected $appends = [
        'full_address',
    ];

    public function fullAddress(): Attribute
    {
        return Attribute::get(
            fn () => sprintf(
                '%s %s %s',
                $this->province,
                $this->city,
                $this->address,
            )
        );
    }
}
