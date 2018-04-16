<?php

namespace Otus\Core;

use Otus\Interfaces\ResponseInterface;

class ResponseBuilder
{
    /**
     * @param array $data
     *
     * @return ResponseInterface
     */
    public function getResponse(array $data): ResponseInterface
    {
        return new JsonResponse($data);
    }
}