<?php

namespace Common\Storage;

use Common\Entity\EntityInterface;

interface FindOneStorageInterface
{
    public function findOne(array $filter = [], array $options = []): ?EntityInterface;
}
