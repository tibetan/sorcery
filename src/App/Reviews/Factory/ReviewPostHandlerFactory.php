<?php

declare(strict_types=1);

namespace App\Reviews\Factory;

use Common\Factory\FactoryInterface;
use App\Reviews\Handler\ReviewPostHandler;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ReviewPostHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): ReviewPostHandler
    {
        return new ReviewPostHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ReviewsStorage::class),
        );
    }
}
