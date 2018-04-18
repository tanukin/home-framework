<?php

use Otus\Core\ControllerFactory;
use Otus\Interfaces\ControllerInterface;
use Otus\Interfaces\RequestInterface;
use Otus\Interfaces\ResponseInterface;
use PHPUnit\Framework\TestCase;

class ControllerFactoryTest extends TestCase
{
    /**
     * @var array
     */
    private $router;

    /**
     * @var RequestInterface
     */
    private $request;

    const REQUEST_URI = "/content";
    const REQUEST_URI_INCORRECT = "/contents";
    const KEY = "uri";

    public function setUp()
    {
        $this->router = [self::REQUEST_URI => $this->getController()];
        $this->request = $this->createMock(RequestInterface::class);
        parent::setUp();
    }

    public function testShould_ReturnController_When_DataCorrect()
    {
        $this->request
            ->method("getParam")
            ->with($this->equalTo(self::KEY))
            ->willReturn(self::REQUEST_URI);

        $controllerFactory = new ControllerFactory($this->router);

        $result = $controllerFactory->getController($this->request);

        $this->assertEquals($this->getController(), $result);
    }

    /**
     *  @expectedException  \Otus\Exceptions\ControllerNotFoundException
     */
    public function testShould_ReturnException_When_ControllerNotFound()
    {
        $this->request
            ->method("getParam")
            ->with($this->equalTo(self::KEY))
            ->willReturn(self::REQUEST_URI_INCORRECT);

        $controllerFactory = new ControllerFactory($this->router);

        $controllerFactory->getController($this->request);
    }

    private function getController(): ControllerInterface
    {
        return new class implements ControllerInterface
        {
            /**
             * {@inheritdoc}
             */
            public function execute(RequestInterface $request): ResponseInterface
            { }
        };
    }
}