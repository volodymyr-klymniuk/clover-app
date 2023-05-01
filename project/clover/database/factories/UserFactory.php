<?php

namespace Database\Factories;

use App\Models\User;
use Database\Dictionary\NullPatient;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * @var string The name of the factory's corresponding model.
     */
    protected string $model = User::class;

    /**
     * @return array Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'first_name'    => NullPatient::getNullPatientFirstName(),
            'last_name'     => NullPatient::getNullPatientLastName(),
            'email'         => NullPatient::getNullPatientEmail(),
            'phone'         => NullPatient::getPhone(),
            'password'      => NullPatient::getNullPatientPasswordHash(),
            'api_token'     => NullPatient::getNullPatientApiToken(),
        ];
    }
}
