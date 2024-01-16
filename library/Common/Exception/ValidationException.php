<?php
declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ValidationException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    AlertExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function wrongParameter(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 400;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/400';
        $e->title = 'Wrong parameter';
        $e->additional['transaction'] = $details;
        return $e;
    }

    public static function emptyParameters(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 400;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/400';
        $e->title = 'Empty parameters';
        $e->additional['transaction'] = $details;
        return $e;
    }

    public function addAdditionalData(array $additional)
    {
        $this->additional['transaction'] = array_merge($this->additional['transaction'], $additional);
    }
}
