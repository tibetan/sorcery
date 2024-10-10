<?php

declare(strict_types=1);

namespace App\Categories\Factory;

use Common\Factory\FactoryInterface;
use App\Categories\Handler\CategoryGetHandler;
use App\Categories\Storage\CategoriesStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class CategoryGetHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): CategoryGetHandler
    {
        return new CategoryGetHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $container->get(CategoriesStorage::class),
        );
    }
}
