<?php
declare(strict_types=1);

namespace Common\Storage;

use MongoDB\DeleteResult;

interface DeleteManyStorageInterface
{
    public function deleteMany(array $filter = [], array $options = []): DeleteResult;
}
