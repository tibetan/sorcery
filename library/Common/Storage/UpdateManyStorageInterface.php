<?php

namespace Common\Storage;

use Common\Entity\EntityInterface;
use MongoDB\UpdateResult;

interface UpdateManyStorageInterface
{
    public function updateMany(EntityInterface $entity, array $filter = [], array $options = []): UpdateResult;
}