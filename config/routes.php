<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
//    $app->get('/', App\Root\Handler\HomePageHandler::class, 'home');
//    $app->get('/api/ping', App\Root\Handler\PingHandler::class, 'api.ping');

    $app->get('/metrics[/]', Common\Handler\MetricsHandler::class, 'metrics');

    $app->get('/api/products/{id}[/]',
        [
            App\Products\Handler\ProductGetHandler::class
        ],
        'api.get.product'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

    $app->get('/api/products[/]',
        [
            App\Products\Handler\ProductsGetHandler::class
        ],
        'api.get.products'
    );

    $app->post('/api/products[/]',
        [
            App\Products\Handler\ProductPostHandler::class
        ],
        'api.post.product'
    );

    $app->patch('/api/products/{id}[/]',
        [
            App\Products\Handler\ProductPatchHandler::class
        ],
        'api.patch.product'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

    $app->delete('/api/products/{id}[/]',
        [
            App\Products\Handler\ProductDeleteHandler::class
        ],
        'api.delete.product'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);
};
