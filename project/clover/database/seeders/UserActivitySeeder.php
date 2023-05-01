<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserActivity;

class UserActivitySeeder extends Seeder
{
    public function run(): void
    {
        UserActivity::factory()->count(20)->create();
    }
}
