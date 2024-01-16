<?php

declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class CriticalException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    CriticalExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function unknownGraylogTransport(string $message, array $details): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'Graylog Transport';
        $e->title = 'Unknown the GrayLog transport';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
