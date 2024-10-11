<?php
declare(strict_types=1);

namespace Common\Storage;

use Common\Entity\EntityInterface;
use Common\Entity\CollectionInterface;
use Common\Exception\StorageException;
use Common\Paginator\Adapter\MongoAdapter;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Unserializable;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\DeleteResult;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;

abstract class AbstractStorage implements
    StorageInterface,
    FindAllStorageInterface,
    FindOneStorageInterface,
    InsertOneStorageInterface,
    UpdateOneStorageInterface,
    DeleteOneStorageInterface
{
    protected Collection $collection;
    protected string $entityName;
    protected string $entityCollectionName;


    public function __construct(protected Database $database)
    {
        $this->collection = $this->getCollection();
        $this->entityName = $this->getEntityName();
        $this->entityCollectionName = $this->getEntityCollectionName();
    }

    public function getCollection(): Collection
    {
        return $this->database->selectCollection($this->getCollectionName());
    }

    public function findAll(array $filter = [], array $options = []): CollectionInterface
    {
        $adapter = new MongoAdapter(
            $this->collection,
            $this->entityName,
            $filter,
            $options
        );
        return new $this->entityCollectionName($adapter);
    }

    public function findOne(array $filter = [], array $options = []): ?EntityInterface
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = ['root' => $this->entityName];
        }

        $document = $this->collection->findOne($filter, $options);
        if (!$document instanceof $this->entityName) return null;

        if (!in_array(Unserializable::class, class_implements($this->entityName), true)) {
            throw new InvalidArgumentException(sprintf(
                'Class %s must implement %s interface',
                $this->entityName,
                Unserializable::class
            ));
        }

        return $document;
    }

    public function insertOne(EntityInterface $entity): InsertOneResult
    {
        if (!$entity instanceof $this->entityName) {
            throw StorageException::collectionHasWrongInstance(
                'Entity must be a `' . $this->entityName . '`'
            );
        }

        $response = $this->collection->insertOne($entity);

        if ($response->getInsertedCount() == 0) {
            throw StorageException::wrongOperation('Insert operation for ' . $this->entityName . ' is wrong');
        }

        return $response;
    }

    public function updateOne(
        EntityInterface $entity,
        array $update = [],
        array $options = []
    ): UpdateResult {
        if (!$entity instanceof $this->entityName) {
            throw StorageException::collectionHasWrongInstance('Entity must be a `' . $this->entityName . '`');
        }

        $response = $this->collection->updateOne(['_id' => new ObjectId($entity->getId())], $update, $options);

        if ($response->getMatchedCount() == 0) {
            throw StorageException::wrongOperation('Update operation for ' . $this->entityName . ' is wrong');
        }

        return $response;
    }

    public function deleteOne(array $filter = [], array $options = []): DeleteResult
    {
        return $this->collection->deleteOne($filter, $options);
    }

    abstract public function getCollectionName(): string;
    abstract public function getEntityName(): string;
    abstract public function getEntityCollectionName(): string;
}
