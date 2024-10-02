<?php
declare(strict_types=1);

namespace Common\Paginator\Adapter;

use Laminas\Paginator\Adapter\AdapterInterface;
use MongoDB\BSON\Unserializable;
use MongoDB\Collection;
use MongoDB\Driver\Query;
use MongoDB\Exception\InvalidArgumentException;

use function class_exists;
use function class_implements;
use function in_array;
use function sprintf;

class MongoAdapter implements AdapterInterface
{
    public function __construct(
        protected Collection $collection,
        protected string $entityClass,
        protected array $filter = [],
        protected array $options = []
    ) {}

    /**
     * {@inheritDoc}
     *
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage): array
    {
        $this->options['skip']  = $offset;
        $this->options['limit'] = $itemCountPerPage;

        $query = new Query($this->filter, $this->options);
        $cursor = $this->collection->getManager()->executeQuery($this->collection->getNamespace(), $query);

        if ($this->entityClass !== null && class_exists($this->entityClass)) {
            if (! in_array(Unserializable::class, class_implements($this->entityClass), true)) {
                throw new InvalidArgumentException(sprintf(
                    'Class %s must implement %s interface',
                    $this->entityClass,
                    Unserializable::class
                ));
            }

            $cursor->setTypeMap(['root' => $this->entityClass]);
        }

        return $cursor->toArray();
    }

    /**
     * {@inheritDoc}
     *
     * @see Countable::count()
     */
    public function count(): int
    {
        return $this->collection->countDocuments($this->filter, $this->options);
    }
}
