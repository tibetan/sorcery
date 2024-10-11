<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories'  => [
                Products\Storage\ProductsStorage::class => Products\Factory\ProductsStorageFactory::class,
                Products\Handler\ProductGetHandler::class => Products\Factory\ProductGetHandlerFactory::class,
                Products\Handler\ProductsGetHandler::class => Products\Factory\ProductsGetHandlerFactory::class,
                Products\Handler\ProductPostHandler::class => Products\Factory\ProductPostHandlerFactory::class,
                Products\Handler\ProductPatchHandler::class => Products\Factory\ProductPatchHandlerFactory::class,
                Products\Handler\ProductDeleteHandler::class => Products\Factory\ProductDeleteHandlerFactory::class,
                Products\Handler\ProductWithReviewsGetHandler::class => Products\Factory\ProductWithReviewsGetHandlerFactory::class,

                Reviews\Storage\ReviewsStorage::class => Reviews\Factory\ReviewsStorageFactory::class,
                Reviews\Handler\ReviewGetHandler::class => Reviews\Factory\ReviewGetHandlerFactory::class,
                Reviews\Handler\ReviewsGetHandler::class => Reviews\Factory\ReviewsGetHandlerFactory::class,
                Reviews\Handler\ReviewPostHandler::class => Reviews\Factory\ReviewPostHandlerFactory::class,
                Reviews\Handler\ReviewPatchHandler::class => Reviews\Factory\ReviewPatchHandlerFactory::class,
                Reviews\Handler\ReviewDeleteHandler::class => Reviews\Factory\ReviewDeleteHandlerFactory::class,

                Categories\Storage\CategoriesStorage::class => Categories\Factory\CategoriesStorageFactory::class,
                Categories\Handler\CategoryGetHandler::class => Categories\Factory\CategoryGetHandlerFactory::class,
                Categories\Handler\CategoriesGetHandler::class => Categories\Factory\CategoriesGetHandlerFactory::class,
                Categories\Handler\CategoryPostHandler::class => Categories\Factory\CategoryPostHandlerFactory::class,
                Categories\Handler\CategoryPatchHandler::class => Categories\Factory\CategoryPatchHandlerFactory::class,
                Categories\Handler\CategoryDeleteHandler::class => Categories\Factory\CategoryDeleteHandlerFactory::class,
            ],
        ];
    }
}
