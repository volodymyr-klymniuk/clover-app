<?php

namespace TestCases;

use Database\Dictionary\NullPatient;
use Illuminate\Support\Str;
use Tests\TestCase;

class CompaniesControllerTest extends TestCase
{
    public function testGetCompaniesHappyFlow()
    {
        $token = $this->getValidToken();
        $headers = [
            'X-API-TOKEN' => $token,
        ];

        /** @see CompaniesController::getCompanies() */
        $this->get('/api/user/companies', $headers);
        $content = $this->response->getContent();
        $this->assertJson($content, 'must be json');
        $companies = \json_decode($content, true);
        $this->assertLessThan(21, \count($companies), 'Response must be limited to 20');
    }

    /**
     * @dataProvider createCompanyDataProvider
     *
     * @param array $parameters
     *
     * @return void
     */
    public function testCreateCompaniesHappyFlow(array $parameters)
    {
        $this->assertTrue(true);
        $headers = [
            'X-API-TOKEN' => $this->getValidToken(),
        ];

        /** @see CompaniesController::createCompany() */
         $this->post('/api/user/companies', $parameters, $headers);
    }

    public static function createCompanyDataProvider(): array
    {
        return [
            [
                [
                    'title' => Str::random(10),
                    'phone' => Str::random(10),
                    'description' => Str::random(10),
                ]
            ],
            [
                [
                    'title' => Str::random(10),
                    'phone' => Str::random(10),
                    'description' => Str::random(10),
                ],
            ],
        ];
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
