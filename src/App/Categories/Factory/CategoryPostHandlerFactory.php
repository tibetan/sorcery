<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use App\Categories\Handler\CategoryPostHandler;
use App\Categories\Storage\CategoriesStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class CategoryPostHandlerFactory
{
    public function __invoke(ContainerInterface $container): CategoryPostHandler
    {
        return new CategoryPostHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(CategoriesStorage::class),
        );
    }
}
