<?php

namespace PluginTemplate\Inc\Application\DTOs;

/**
 * Odpowiedź REST niezależna od hosta.
 */
class ApiResponse
{
    public ?string $errorCode = null;
    public ?string $errorMessage = null;

    public function __construct(
        public mixed $data = null,
        public int $status = 200,
    )
    {
    }

    public static function error(string $code, string $message, int $status = 500): self
    {
        $response = new self(null, $status);
        $response->errorCode = $code;
        $response->errorMessage = $message;

        return $response;
    }

    public function isError(): bool
    {
        return $this->errorCode !== null;
    }
}
