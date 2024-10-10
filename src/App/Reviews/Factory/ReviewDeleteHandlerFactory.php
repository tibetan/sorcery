<?php

declare(strict_types=1);

namespace App\Reviews\Factory;

use Common\Factory\FactoryInterface;
use App\Reviews\Handler\ReviewDeleteHandler;
use App\Reviews\Storage\ReviewsStorage;
use Psr\Container\ContainerInterface;

class ReviewDeleteHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): ReviewDeleteHandler
    {
        return new ReviewDeleteHandler(
            $container->get(ReviewsStorage::class)
        );
    }
}
