<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use Common\Factory\FactoryInterface;
use App\Categories\Storage\CategoriesStorage;
use Interop\Container\ContainerInterface;
use MongoDB\Database;

class CategoriesStorageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): CategoriesStorage
    {
        return new CategoriesStorage(
            $container->get(Database::class)
        );
    }
}
