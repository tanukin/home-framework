<?php

namespace Otus\Dto;

class Error implements \JsonSerializable
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    const BAD_REQUEST = 400;

    /**
     * Film constructor.
     *
     * @param int $status
     * @param string $message
     */
    public function __construct(int $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
        ];
    }
}