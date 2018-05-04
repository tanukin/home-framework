<?php

namespace Otus\Core;

use Otus\Interfaces\RequestBuilderInterface;
use Otus\Interfaces\RequestInterface;

class RequestBuilder implements RequestBuilderInterface
{
    const METHOD_TYPE_POST = "POST";
    const CONTENT_TYPE_JSON = "application/json";

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

        if ($_SERVER["REQUEST_METHOD"] == self::METHOD_TYPE_POST &&
            $_SERVER["CONTENT_TYPE"] == self::CONTENT_TYPE_JSON) {

            $json = file_get_contents("php://input");
            $post = json_decode($json, true);
        }

        return new Request($get, $post);
    }
}