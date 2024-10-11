<?php

declare(strict_types=1);

namespace App\Reviews\Factory;

use Common\Factory\FactoryInterface;
use App\Reviews\Handler\ReviewsGetByProductHandler;
use App\Reviews\Storage\ReviewsStorage;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ReviewsGetByProductHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): ReviewsGetByProductHandler
    {
        return new ReviewsGetByProductHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ReviewsStorage::class),
            $container->get(ProductsStorage::class),
        );
    }
}
