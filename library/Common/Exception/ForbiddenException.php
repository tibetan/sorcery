<?php
declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ForbiddenException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    NoticeExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function notAccess(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 403;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/403';
        $e->title = 'Not access for content';
        $e->additional['transaction'] = $details;
        return $e;
    }
}