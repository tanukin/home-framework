<?php

namespace Otus\Core;

use Otus\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    /**
     * @var array
     */
    private $get;
    /**
     * @var array
     */
    private $post;

    /**
     * Request constructor.
     *
     * @param array $get
     * @param array $post
     */
    public function __construct(array $get, array $post)
    {
        $this->get = $get;
        $this->post = $post;
    }

    /**
     * {@inheritdoc}
     */
    public function getParam(string $key, string $default = null): ?string
    {
        if (array_key_exists($key, $this->get))
            return $this->get[$key];

        if (array_key_exists($key, $this->post))
            return $this->post[$key];

        return $default;
    }
}