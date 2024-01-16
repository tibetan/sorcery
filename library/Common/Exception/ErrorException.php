<?php

declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ErrorException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    ErrorExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function test(string $message, array $details): self
    {
        $e = new self($message);
        $e->status = 400;
        $e->detail = $message;
        $e->type = 'http://mezzio/test/api/doc/test-exception';
        $e->title = 'Example for test exception';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
