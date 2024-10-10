<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use App\Categories\Handler\CategoriesGetHandler;
use App\Categories\Storage\CategoriesStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class CategoriesGetHandlerFactory
{
    public function __invoke(ContainerInterface $container): CategoriesGetHandler
    {
        return new CategoriesGetHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(CategoriesStorage::class),
        );
    }
}
