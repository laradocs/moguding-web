<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function find(int $id, bool $throw = false): ?User;

    public function updateOrCreate(array $attributes, int $id = 0): User;

    public function existsByEmail(string $email): bool;

    public function existsByName(string $name): bool;
}
