<?php

namespace Database\Seeders;

use Database\Dictionary\NullPatient;
use Database\Dictionary\ChangePasswordPatient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class StartupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table(User::TABLE_NAME)->insert([
            'first_name' => NullPatient::getNullPatientFirstName(),
            'last_name' => NullPatient::getNullPatientLastName(),
            'email' => NullPatient::getNullPatientEmail(),
            'password' => NullPatient::getNullPatientPasswordHash(),
            'phone' => NullPatient::getPhone(),
            'api_token' => NullPatient::getNullPatientApiToken(),
        ]);

        DB::table(User::TABLE_NAME)->insert([
            'first_name' => ChangePasswordPatient::getNullPatientFirstName(),
            'last_name' => ChangePasswordPatient::getNullPatientLastName(),
            'email' => ChangePasswordPatient::getNullPatientEmail(),
            'password' => ChangePasswordPatient::getNullPatientPasswordHash(),
            'phone' => ChangePasswordPatient::getPhone(),
            'api_token' => ChangePasswordPatient::getNullPatientApiToken(),
        ]);
    }
}
