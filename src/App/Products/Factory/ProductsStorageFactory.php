<?php
declare(strict_types=1);

namespace App\Products\Factory;

use App\Products\Storage\ProductsStorage;
use Interop\Container\ContainerInterface;
use MongoDB\Database;

class ProductsStorageFactory
{
    public function __invoke(ContainerInterface $container): ProductsStorage
    {
        return new ProductsStorage(
            $container->get(Database::class)
        );
    }
}
