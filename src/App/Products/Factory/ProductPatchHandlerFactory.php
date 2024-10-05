<?php

declare(strict_types=1);

namespace App\Products\Factory;

use App\Products\Handler\ProductPatchHandler;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ProductPatchHandlerFactory
{
    public function __invoke(ContainerInterface $container): ProductPatchHandler
    {
        return new ProductPatchHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ProductsStorage::class),
        );
    }
}
