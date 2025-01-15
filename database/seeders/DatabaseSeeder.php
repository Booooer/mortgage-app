<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // seeders for local environment (dev)
        if (app()->isLocal()) {
            $this->call(DevUsersSeeder::class);
        }
    }
}
