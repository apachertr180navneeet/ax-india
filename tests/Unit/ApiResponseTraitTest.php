<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiResponseTraitTest extends TestCase
{
    private $responder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->responder = new class
        {
            use \App\Traits\ApiResponse;

            public function callSuccess($data, $message = 'Success', $code = 200)
            {
                return $this->successResponse($data, $message, $code);
            }

            public function callError($message = 'Error', $code = 400, $errors = [])
            {
                return $this->errorResponse($message, $code, $errors);
            }

            public function callNotFound($message = 'Resource not found')
            {
                return $this->notFoundResponse($message);
            }
        };
    }

    public function test_success_response_returns_correct_structure()
    {
        $response = $this->responder->callSuccess(['key' => 'value'], 'Custom message', 201);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($data['success']);
        $this->assertEquals('Custom message', $data['message']);
        $this->assertEquals(['key' => 'value'], $data['data']);
    }

    public function test_error_response_returns_correct_structure()
    {
        $response = $this->responder->callError('Error occurred', 422, ['field' => ['Validation error']]);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertFalse($data['success']);
        $this->assertEquals('Error occurred', $data['message']);
        $this->assertEquals(['field' => ['Validation error']], $data['errors']);
    }

    public function test_not_found_response()
    {
        $response = $this->responder->callNotFound('Video not found');
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertFalse($data['success']);
        $this->assertEquals('Video not found', $data['message']);
        $this->assertArrayNotHasKey('data', $data);
    }
}
