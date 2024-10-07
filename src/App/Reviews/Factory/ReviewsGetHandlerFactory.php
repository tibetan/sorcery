<?php

declare(strict_types=1);

namespace App\Reviews\Factory;

use App\Reviews\Handler\ReviewsGetHandler;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ReviewsGetHandlerFactory
{
    public function __invoke(ContainerInterface $container): ReviewsGetHandler
    {
        return new ReviewsGetHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ReviewsStorage::class),
        );
    }
}
