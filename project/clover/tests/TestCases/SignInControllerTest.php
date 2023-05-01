<?php

namespace TestCases;

use Database\Dictionary\NullPatient;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    /**
     * @see AuthController::signIn
     *
     * @return void
     */
    public function testWrongSignIn()
    {
        $email = NullPatient::getNullPatientEmail();
        $password = 'qwa qwa';
        $parameters = [
            'email' => $email,
            'password' => $password,
        ];

        $this->post('/api/user/sign-in', $parameters);
        $content = $this->response->getContent();
        $this->assertStringContainsString('Password does not match', $this->response->getContent());
    }

    /**
     * @see AuthController::signIn
     *
     * @return void
     */
    public function testSignIn()
    {
        $email = NullPatient::getNullPatientEmail();
        $password = NullPatient::getNullPatientPasswordOrigin();
        $parameters = [
            'email' => $email,
            'password' => $password,
        ];

        $this->post('/api/user/sign-in', $parameters);
        $content = $this->response->getContent();
        $this->assertJson($content);
    }
}
