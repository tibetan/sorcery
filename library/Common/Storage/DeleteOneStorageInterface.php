<?php
declare(strict_types=1);

namespace Common\Storage;

use MongoDB\DeleteResult;

interface DeleteOneStorageInterface
{
    public function deleteOne(array $filter = [], array $options = []): DeleteResult;
}
