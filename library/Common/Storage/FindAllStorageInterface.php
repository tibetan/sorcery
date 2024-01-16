<?php

namespace Common\Storage;

use Common\Entity\CollectionInterface;

interface FindAllStorageInterface
{
    public function findAll(array $filter = [], array $options = []): CollectionInterface;
}
