<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

Role::create([
    'name' => 'admin'
]);

Role::create([
    'name' => 'pemberantasan'
]);

Role::create([
    'name' => 'p2m'
]);
