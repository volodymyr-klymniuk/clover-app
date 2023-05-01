<?php

namespace TestCases;

use Database\Dictionary\NullPatient;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * @see RegisterController::register()
     *
     * @return void
     */
    public function testRegisterNewUserBadParameters()
    {
        $parameters = [ 'password' => 'password1', 'phone' => '292-442-231',];
        $this->post('api/user/register', $parameters);
        $content = $this->response->getContent();
        $this->assertStringContainsString(
            'Сant create user',
            $this->response->getContent()
        );
    }

    /**
     * @see RegisterController::register()
     *
     * @return void
     */
    public function testRegisterNewUserExists()
    {
        $parameters = [
            'first_name' => 'cmcgv swd',
            'last_name' => 'swd kmcgv',
            'email' => NullPatient::getNullPatientEmail(),
            'password' => 'password1',
            'phone' => '292-442-231',
        ];

        $this->post('api/user/register', $parameters);
        $this->assertStringContainsString('User already exists', $this->response->getContent());
    }

    /**
     * @see RegisterController::register()
     *
     * @return void
     */
    public function testRegisterNewUserAuthorized()
    {
        $token = $this->getValidToken();
        $headers = [ 'X-API-TOKEN' => $token, ];
        $parameters = [
            'first_name' => 'cmcgv swd',
            'last_name' => 'swd kmcgv',
            'email' => Str::random(10),
            'password' => 'password1',
            'phone' => '292-442-231',
        ];

        $this->post('api/user/register', $parameters, $headers);
        $this->assertStringContainsString('User already authorized', $this->response->getContent());
    }

    /**
     * @see RegisterController::register()
     *
     * @return void
     */
    public function testRegisterNewUserNonAuthorized()
    {
        $parameters = [
            'first_name' => 'cmcgv swd',
            'last_name' => 'swd kmcgv',
            'email' => Str::random(10),
            'password' => 'password1',
            'phone' => '292-442-231',
        ];

        $this->post('api/user/register', $parameters);
        $content = $this->response->getContent();
        $this->assertJson($content);
    }

    private function getValidToken(): string
    {
        $data = [
            "email" => NullPatient::getNullPatientEmail(),
            "password" => NullPatient::getNullPatientPasswordOrigin(),
        ];

        /** @see \App\Http\Controllers\AuthController::signIn() */
        $this->post('/api/user/sign-in', $data);
        $content = $this->response->getContent();
        $token = \json_decode($content, true)['data']['api_token'];

        return $token;
    }
}
