<?php
declare(strict_types=1);

namespace Common\Storage;

use MongoDB\Collection;
use MongoDB\Database;

abstract class AbstractStorage implements StorageInterface
{
    protected string $collectionName;

    public function __construct(protected Database $database)
    {
    }

    public function getCollection(): Collection
    {
        return $this->database->selectCollection($this->getCollectionName());
    }

    abstract public function getCollectionName(): string;
}
