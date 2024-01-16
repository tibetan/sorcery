<?php
declare(strict_types=1);

namespace Common\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class StorageException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    ErrorExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function needSetCollectionName(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'Storage Exception';
        $e->title = 'Empty collection name';
        $e->additional['transaction'] = $details;
        return $e;
    }

    public static function collectionHasWrongParameter(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'Storage Exception';
        $e->title = 'The collection has wrong initialization parameters';
        $e->additional['transaction'] = $details;
        return $e;
    }

    public static function collectionHasWrongInstance(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'Storage Exception';
        $e->title = 'The collection has wrong instance';
        $e->additional['transaction'] = $details;
        return $e;
    }

    public static function wrongOperation(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'Storage Exception';
        $e->title = 'Operation is wrong';
        $e->additional['transaction'] = $details;
        return $e;
    }
}