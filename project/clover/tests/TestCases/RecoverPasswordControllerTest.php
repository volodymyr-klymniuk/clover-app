<?php

namespace TestCases;

use Database\Dictionary\ChangePasswordPatient;
use Tests\TestCase;

class RecoverPasswordControllerTest extends TestCase
{
    private static $activateToken = null;

    /**
     * @see RecoverController::createRecoverRequest()
     *
     * @return void
     */
    public function testRequestChangePassword()
    {
        $parameters = [
            'email' => ChangePasswordPatient::getNullPatientEmail(),
        ];
        $this->post("/api/user/recover-password", $parameters);
        $response = $this->response->getContent();
        $token = \json_decode($response, true)['reset_token'];
        self::$activateToken = $token;
        $this->assertNotEmpty($token);
    }

    /**
     * @see RecoverController::createRecoverRequest()
     *
     * @depends testRequestChangePassword
     *
     * @return void
     */
    public function testWrongPasswordActivated()
    {
        $parameters = [
            'email' => ChangePasswordPatient::getNullPatientEmail(),
            'token' => self::$activateToken . '1',
        ];
        $this->patch('/api/user/recover-password', $parameters);
        $content = $this->response->getContent();
        $this->assertStringContainsString('User with email: init2@gmail.com activate token', $content);
    }

    /**
     * @depends testWrongPasswordActivated
     *
     * @return void
     */
    public function testCorrectPasswordActivated()
    {
        $parameters = [
            'email' => ChangePasswordPatient::getNullPatientEmail(),
            'activate_token' => self::$activateToken,
        ];
        $this->patch('/api/user/recover-password', $parameters);
        $result = \json_decode($this->response->getContent(), true)['status'];
        $this->assertEquals('ok', $result);
        self::$activateToken = null;
    }
}
