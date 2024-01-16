<?php

namespace Common\Storage;

use Common\Entity\EntityInterface;
use MongoDB\InsertOneResult;

interface InsertOneStorageInterface
{
    public function insertOne(EntityInterface $entity): InsertOneResult;
}
