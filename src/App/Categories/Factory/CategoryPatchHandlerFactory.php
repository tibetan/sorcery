<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use App\Categories\Handler\CategoryPatchHandler;
use App\Categories\Storage\CategoriesStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class CategoryPatchHandlerFactory
{
    public function __invoke(ContainerInterface $container): CategoryPatchHandler
    {
        return new CategoryPatchHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(CategoriesStorage::class),
        );
    }
}
