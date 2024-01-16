<?php

namespace Common\Storage;

use MongoDB\Collection;

interface StorageInterface
{
    public function getCollection(): Collection;
    public function getCollectionName(): string;
}