<?php
declare(strict_types=1);

namespace App\Products\Storage;

use App\Products\Entity\Products;
use App\Products\Entity\ProductsCollection;
use Common\Exception\StorageException;
use Common\Entity\EntityInterface;
use Common\Paginator\Adapter\MongoAdapter;
use Common\Storage\AbstractStorage;
use Common\Storage\DeleteOneStorageInterface;
use Common\Storage\FindAllStorageInterface;
use Common\Storage\FindOneStorageInterface;
use Common\Storage\InsertOneStorageInterface;
use MongoDB\BSON\Unserializable;
use MongoDB\InsertOneResult;
use MongoDB\DeleteResult;
use MongoDB\Exception\InvalidArgumentException;

class ProductsStorage extends AbstractStorage implements
    FindAllStorageInterface,
    FindOneStorageInterface,
    InsertOneStorageInterface,
    DeleteOneStorageInterface
{
    public function getCollectionName(): string
    {
        return 'products';
    }

    public function findAll(array $filter = [], array $options = []): ProductsCollection
    {
        $adapter = new MongoAdapter(
            $this->getCollection(),
            Products::class,
            $filter,
            $options
        );
        return new ProductsCollection($adapter);
    }

    public function findOne(array $filter = [], array $options = []): ?Products
    {
        if (!isset($options['typeMap']))
            $options['typeMap'] = ['root' => Products::class];

        $document = $this->getCollection()->findOne($filter, $options);
        if (!$document instanceof Products) return null;

        if (!in_array(Unserializable::class, class_implements(Products::class), true)) {
            throw new InvalidArgumentException(sprintf(
                'Class %s must implement %s interface',
                Products::class,
                Unserializable::class
            ));
        }

        return $document;
    }

    public function insertOne(EntityInterface $entity): InsertOneResult
    {
        if (!$entity instanceof Products) {
            throw StorageException::collectionHasWrongInstance('Entity must be a `Products`');
        }

        $response = $this->getCollection()->insertOne($entity);

        if ($response->getInsertedCount() == 0)
            throw StorageException::wrongOperation('Insert operation for message is wrong');

        return $response;
    }

    public function deleteOne(array $filter = [], array $options = []): DeleteResult
    {
        return $this->getCollection()->deleteOne($filter, $options);
    }
}
