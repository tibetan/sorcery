<?php

declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class UnauthorizedException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    ErrorExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function unknownJwt(string $message, array $details = null): self
    {
        $e = new self($message);
        $e->status = 401;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/401';
        $e->title = 'Unknown JWT';
        return $e;
    }

    public static function errorHeader(string $message, array $details = null): self
    {
        $e = new self($message);
        $e->status = 401;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/401';
        $e->title = 'Error authorization header';
        return $e;
    }

}
