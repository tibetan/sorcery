<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use Common\Factory\FactoryInterface;
use App\Categories\Handler\CategoryDeleteHandler;
use App\Categories\Storage\CategoriesStorage;
use Psr\Container\ContainerInterface;

class CategoryDeleteHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): CategoryDeleteHandler
    {
        return new CategoryDeleteHandler(
            $container->get(CategoriesStorage::class)
        );
    }
}
