<?php

namespace Common\Storage;

use Common\Entity\EntityInterface;
use MongoDB\UpdateResult;

interface UpdateOneStorageInterface
{
    public function updateOne(EntityInterface $entity, array $filter = [], array $options = []): UpdateResult;
}