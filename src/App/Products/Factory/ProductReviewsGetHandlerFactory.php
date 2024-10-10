<?php

declare(strict_types=1);

namespace App\Products\Factory;

use Common\Factory\FactoryInterface;
use App\Products\Handler\ProductReviewsGetHandler;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ProductReviewsGetHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): ProductReviewsGetHandler
    {
        return new ProductReviewsGetHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ProductsStorage::class),
        );
    }
}
