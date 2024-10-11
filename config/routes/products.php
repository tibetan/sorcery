<?php

declare(strict_types=1);

return static function ($app) {
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

    $app->get('/api/products/{id}/with-reviews[/]',
        [
            App\Products\Handler\ProductWithReviewsGetHandler::class
        ],
        'api.get.product.with-reviews'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

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
