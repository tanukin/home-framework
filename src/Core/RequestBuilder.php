<?php

namespace Otus\Core;

use Otus\Interfaces\RequestBuilderInterface;
use Otus\Interfaces\RequestInterface;

class RequestBuilder implements RequestBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRequest(array $get, array $post): RequestInterface
    {
        $uri = $_SERVER["REQUEST_URI"];
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        $get['uri'] = $uri;

        return new Request($get, $post);
    }
}