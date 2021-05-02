<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return array|void
     */
    protected function setUpTraits()
    {
        parent::setUpTraits();
    }

    protected function getData(TestResponse $response)
    {
        return $response->json('data')[0];
    }

    protected function assertJsonResponse(TestResponse $response, $data = [], $code = 200)
    {
        $response->assertStatus($code);

        $responseObject = [
            'status' => 'Success',
            'success' => true,
            'message' => null,
            'data' => json_decode(json_encode($data), true),
            'execution_time' => null,
        ];

        $this->assertEquals($responseObject, json_decode($response->getContent(), true));
    }
}
