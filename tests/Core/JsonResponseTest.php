<?php

use Otus\Core\JsonResponse;
use Otus\Dto\Error;
use Otus\Entities\Film;
use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{
    const DATA_FILM = [
        'id' => 1,
        'title' => 'title',
        'release_date' => '2018-04-18'
    ];
    const JSON_DATA_RESULT_FILM = '[{"id":1,"title":"title","release-date":"2018-04-18"}]';
    const ERROR_CODE = Error::BAD_REQUEST;
    const ERROR_MESSAGE = "";
    const JSON_DATA_RESULT_ERROR = '[{"status":400,"message":""}]';

    public function testShould_ReturnJsonFilms_When_CorrectData()
    {
        $jsonResponse = new JsonResponse($this->getArrayFilms());
        $result = $jsonResponse->getResponse();

        $this->assertEquals(self::JSON_DATA_RESULT_FILM, $result);
    }

    public function testShould_ReturnJsonError()
    {
        $jsonResponse = new JsonResponse($this->getArrayError(self::ERROR_CODE, self::ERROR_MESSAGE));
        $result = $jsonResponse->getResponse();

        $this->assertEquals(self::JSON_DATA_RESULT_ERROR, $result);
    }

    private function getArrayFilms(): array
    {
        return [
            new Film(self::DATA_FILM['id'], self::DATA_FILM['title'], self::DATA_FILM['release_date'])
        ];
    }

    private function getArrayError(int $status, string $message): array
    {
        return [
            new Error($status, $message)
        ];
    }
}