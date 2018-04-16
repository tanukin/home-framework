<?php

namespace Otus\Core;

use Otus\Interfaces\ResponseInterface;

class HtmlResponse implements ResponseInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * HtmlResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Returns data of response
     *
     * @return string
     */
    public function getResponse(): string
    {
        return (string)$this->data;
    }
}