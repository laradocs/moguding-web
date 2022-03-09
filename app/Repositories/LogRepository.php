<?php

namespace App\Repositories;

use App\Models\Log;

interface LogRepository
{
    public function create ( array $attributes ): Log;
}
