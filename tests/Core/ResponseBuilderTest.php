<?php

use Otus\Core\JsonResponse;
use Otus\Core\ResponseBuilder;
use Otus\Dto\Error;
use Otus\Interfaces\ResponseInterface;
use PHPUnit\Framework\TestCase;

class ResponseBuilderTest extends TestCase
{
    const DATA = [
        'id' => 1,
        'title' => 'title',
        'release_date' => '2018-04-18'
    ];

    const ERROR_CODE = Error::BAD_REQUEST;
    const ERROR_MESSAGE = "";

    public function testShould_ReturnErrorDto()
    {
        $responseBuilder = new ResponseBuilder();
        $result = $responseBuilder->createError(self::ERROR_CODE, self::ERROR_MESSAGE);

        $this->assertEquals($this->getError(self::ERROR_CODE, self::ERROR_MESSAGE), $result);
    }

    public function testShould_ReturnJsonResponse()
    {
        $responseBuilder = new ResponseBuilder();
        $result = $responseBuilder->getResponse(self::DATA);

        $this->assertEquals($this->getJsonResponse(self::DATA), $result);
    }

    private function getJsonResponse(array $data): ResponseInterface
    {
        return new JsonResponse($data);
    }

    private function getError(int $status, string $message): Error
    {
        return new Error($status, $message);
    }
}