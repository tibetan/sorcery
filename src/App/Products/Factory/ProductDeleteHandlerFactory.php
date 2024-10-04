<?php

declare(strict_types=1);

namespace App\Products\Factory;

use App\Products\Handler\ProductDeleteHandler;
use App\Products\Storage\ProductsStorage;
use Psr\Container\ContainerInterface;

class ProductDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container): ProductDeleteHandler
    {
        return new ProductDeleteHandler(
            $container->get(ProductsStorage::class)
        );
    }
}
