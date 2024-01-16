<?php

declare(strict_types=1);

namespace App;

use App\Products\Storage\ProductsStorage;

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
//        $productsStorage = new ProductsStorage();
//        $productsStorage->findAll();
//        var_dump($productsStorage);
//        exit;
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Root\Handler\PingHandler::class => Root\Handler\PingHandler::class,
            ],
            'factories'  => [
                Root\Handler\HomePageHandler::class => Root\Handler\HomePageHandlerFactory::class,
                Products\Handler\ProductGetHandler::class => Products\Factory\ProductGetHandlerFactory::class,
                Products\Handler\ProductsGetHandler::class => Products\Factory\ProductsGetHandlerFactory::class,
                Products\Storage\ProductsStorage::class => Products\Factory\ProductsStorageFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
