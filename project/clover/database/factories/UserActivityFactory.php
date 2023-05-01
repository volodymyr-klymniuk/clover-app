<?php

namespace Database\Factories;

use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityFactory extends Factory
{
    /**
     * @var string The name of the factory's corresponding model.
     */
    protected $model = UserActivity::class;

    /**
     * @return array  Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'event' => 'new',
            'created_at' => (new \DateTime()),
        ];
    }
}
