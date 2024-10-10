<?php

declare(strict_types=1);

namespace App\Categories\Storage;

use App\Categories\Entity\Categories;
use App\Categories\Entity\CategoriesCollection;
use Common\Storage\AbstractStorage;

class CategoriesStorage extends AbstractStorage
{
    public function getCollectionName(): string
    {
        return 'categories';
    }

    public function getEntityName(): string
    {
        return Categories::class;
    }

    public function getEntityCollectionName(): string
    {
        return CategoriesCollection::class;
    }
}
