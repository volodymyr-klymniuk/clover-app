<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         $this->call([ StartupSeeder::class, UserActivitySeeder::class, CompanySeeder::class, ]);
    }
}
