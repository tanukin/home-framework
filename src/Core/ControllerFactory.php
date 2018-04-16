<?php

namespace Otus\Core;

use Otus\Exceptions\ControllerNotFoundException;
use Otus\Interfaces\ControllerFactoryInterface;
use Otus\Interfaces\ControllerInterface;
use Otus\Interfaces\RequestInterface;

class ControllerFactory implements ControllerFactoryInterface
{
    /**
     * @var array
     */
    private $router;

    /**
     * ControllerFactory constructor.
     *
     * @param array $router
     */
    public function __construct(array $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function getController(RequestInterface $request): ControllerInterface
    {
        $uri = $request->getParam('uri');
        if (!isset($this->router[$uri]))
            throw new ControllerNotFoundException(sprintf("Controller for url = %s not found", $uri));

        return $this->router[$uri];
    }
}