<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use App\Categories\Handler\CategoryDeleteHandler;
use App\Categories\Storage\CategoriesStorage;
use Psr\Container\ContainerInterface;

class CategoryDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container): CategoryDeleteHandler
    {
        return new CategoryDeleteHandler(
            $container->get(CategoriesStorage::class)
        );
    }
}
