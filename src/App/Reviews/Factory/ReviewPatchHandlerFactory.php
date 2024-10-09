<?php

declare(strict_types=1);

namespace App\Reviews\Factory;

use App\Reviews\Handler\ReviewPatchHandler;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ReviewPatchHandlerFactory
{
    public function __invoke(ContainerInterface $container): ReviewPatchHandler
    {
        return new ReviewPatchHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(ReviewsStorage::class),
        );
    }
}
