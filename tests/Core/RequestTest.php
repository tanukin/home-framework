<?php

use Otus\Core\Request;
use Otus\Interfaces\RequestInterface;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @var RequestInterface
     */
    private $request;

    const KEY = "get-param";
    const SECOND_KEY = "get-params";
    const GET = [self::KEY => "first"];
    const POST = [];

    public function setUp()
    {
        $this->request = new Request(self::GET, self::POST);
        parent::setUp();
    }

    public function testShould_ReturnString_When_CorrectKey()
    {
        $result = $this->callMethodGetParam(self::KEY);

        $this->assertEquals(self::GET[self::KEY], $result);
    }

    public function testShould_ReturnNull_When_NotFoundKey()
    {
        $this->assertNull($this->callMethodGetParam(self::SECOND_KEY));
    }

    private function callMethodGetParam(string $key): ?string
    {
        return $this->request->getParam($key);
    }
}