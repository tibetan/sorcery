<?php
declare(strict_types=1);

namespace App\Reviews\Factory;

use App\Reviews\Storage\ReviewsStorage;
use Interop\Container\ContainerInterface;
use MongoDB\Database;

class ReviewsStorageFactory
{
    public function __invoke(ContainerInterface $container): ReviewsStorage
    {
        return new ReviewsStorage(
            $container->get(Database::class)
        );
    }
}
