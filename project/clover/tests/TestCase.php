<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function tearDown(): void
    {
//        DB::connection('master')->disconnect();
//        DB::disconnect();
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';

        return require __DIR__.'/../bootstrap/app.php';
    }
}
