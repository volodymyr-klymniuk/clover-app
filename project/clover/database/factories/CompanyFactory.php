<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => 'Company #',
            'phone' => '777-777-777',
            'description' => 'Seeded data for tests',
        ];
    }
}
