<?php

namespace Otus\Core;

use Otus\Dto\Error;
use Otus\Interfaces\ResponseInterface;

class ResponseBuilder
{
    /**
     * @param int $status
     * @param string $message
     *
     * @return Error
     */
    public function createError(int $status, string $message): Error
    {
        return new Error($status, $message);
    }

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