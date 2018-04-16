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
        if (!empty($this->get[$key]))
            return $this->get[$key];

        return $default;
    }
}