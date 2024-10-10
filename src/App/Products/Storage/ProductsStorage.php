<?php

declare(strict_types=1);

namespace App\Products\Storage;

use App\Products\Entity\Products;
use App\Products\Entity\CategoriesCollection;
use Common\Entity\EntityInterface;
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
        return CategoriesCollection::class;
    }

    /**
     * @param array $filter
     * @param array $options
     * @return EntityInterface|null
     */
    public function findOneWithReviews(array $filter = [], array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = ['root' => $this->entityName];
        }

        $pipeline = [
            [
                '$match' => $filter
            ],
            [
                '$lookup' => [
                    'from' => 'reviews',
                    'localField' => '_id',
                    'foreignField' => 'product_id',
                    'as' => 'reviews',
                ]
            ]
        ];

        $result = $this->collection->aggregate($pipeline, $options);

        foreach ($result as $document) {
            if ($document instanceof $this->entityName) {
                return $document;
            }
        }

        return null;
    }
}
