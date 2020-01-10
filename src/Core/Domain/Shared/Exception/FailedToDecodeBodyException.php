<?php


namespace App\Core\Domain\Shared\Exception;


use Symfony\Component\HttpFoundation\Response;

final class FailedToDecodeBodyException extends Exception
{
    public function __construct(\JsonException $e)
    {
        parent::__construct('Syntax error: '. $e->getMessage(), $e->getCode(), $e);
    }

    public function getResponse(string $body = '', int $status = 400, array $headers = []): Response
    {
        if (!isset($headers['x-debug'])) {
            $headers['x-debug'] = 'Syntax: '.$this->getMessage();
        }

        return new Response($body, $status, $headers);
    }
}