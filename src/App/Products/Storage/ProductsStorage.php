<?php

declare(strict_types=1);

namespace App\Products\Storage;

use App\Products\Entity\Products;
use App\Products\Entity\ProductsCollection;
use Common\Storage\AbstractStorage;

class ProductsStorage extends AbstractStorage
{
    public function getCollectionName(): string
    {
        return 'products';
    }

    public function getEntityName(): string
    {
        return Products::class;
    }

    public function getEntityCollectionName(): string
    {
        return ProductsCollection::class;
    }
}
