<?php

declare(strict_types=1);

return static function ($app) {
    $app->get('/api/categories/{id}[/]',
        [
            App\Categories\Handler\CategoryGetHandler::class
        ],
        'api.get.category'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

    $app->get('/api/categories[/]',
        [
            App\Categories\Handler\CategoriesGetHandler::class
        ],
        'api.get.categories'
    );

    $app->post('/api/categories[/]',
        [
            App\Categories\Handler\CategoryPostHandler::class
        ],
        'api.post.category'
    );

    $app->patch('/api/categories/{id}[/]',
        [
            App\Categories\Handler\CategoryPatchHandler::class
        ],
        'api.patch.category'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

    $app->delete('/api/categories/{id}[/]',
        [
            App\Categories\Handler\CategoryDeleteHandler::class
        ],
        'api.delete.category'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);
};
