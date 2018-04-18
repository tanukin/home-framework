<?php

use Otus\Core\Request;
use Otus\Core\RequestBuilder;
use Otus\Interfaces\RequestInterface;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    const REQUEST_URI = "/content";
    const REQUEST_URI_WITH_PARAMS = self::REQUEST_URI . "?get-param=first";
    const REQUEST_URI_WITHOUT_PARAMS = self::REQUEST_URI;
    const KEY = "uri";
    const GET = [];
    const POST = [];


    public function dataProvider()
    {
        return [
            [self::REQUEST_URI_WITHOUT_PARAMS, $this->getRequest()],
            [self::REQUEST_URI_WITH_PARAMS, $this->getRequest()],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testShould_ReturnRequest_When_correctData(string $requestUri, RequestInterface $expected)
    {
        $_SERVER["REQUEST_URI"] = self::REQUEST_URI_WITH_PARAMS;

        $requestBuilder = new RequestBuilder();
        $result = $requestBuilder->getRequest(self::GET, self::POST);

        $this->assertEquals($expected, $result);
    }

    private function getRequest(): RequestInterface
    {
        return new Request([self::KEY => self::REQUEST_URI], self::POST);
    }

}