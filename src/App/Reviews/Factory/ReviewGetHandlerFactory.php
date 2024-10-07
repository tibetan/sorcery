<?php

declare(strict_types=1);

namespace App\Reviews\Factory;

use App\Reviews\Handler\ReviewGetHandler;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ReviewGetHandlerFactory
{
    public function __invoke(ContainerInterface $container): ReviewGetHandler
    {
        return new ReviewGetHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ReviewsStorage::class),
        );
    }
}
