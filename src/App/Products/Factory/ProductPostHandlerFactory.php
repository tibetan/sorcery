<?php

declare(strict_types=1);

namespace App\Products\Factory;

use App\Products\Handler\ProductPostHandler;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ProductPostHandlerFactory
{
    public function __invoke(ContainerInterface $container): ProductPostHandler
    {
        return new ProductPostHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ProductsStorage::class),
        );
    }
}
