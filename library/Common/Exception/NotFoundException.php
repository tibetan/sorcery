<?php

declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class NotFoundException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    InfoExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function entity(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 404;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/404';
        $e->title = 'Not found entity';
        $e->additional['transaction'] = $details;
        return $e;
    }

    public static function collection(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 404;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/404';
        $e->title = 'Not found collection';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
