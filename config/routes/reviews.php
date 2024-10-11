<?php

declare(strict_types=1);

return static function ($app) {
    $app->get('/api/reviews/{id}[/]',
        [
            App\Reviews\Handler\ReviewGetHandler::class
        ],
        'api.get.review'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

    $app->get('/api/reviews[/]',
        [
            App\Reviews\Handler\ReviewsGetHandler::class
        ],
        'api.get.reviews'
    );

//    $app->get('/api/products/{id}/reviews[/]',
//        [
//            App\Reviews\Handler\ProductReviewsGetHandler::class
//        ],
//        'api.get.product.reviews'
//    )->setOptions([
//        'tokens' => [
//            'id' => '\w\d+',
//        ],
//    ]);

    $app->post('/api/reviews[/]',
        [
            App\Reviews\Handler\ReviewPostHandler::class
        ],
        'api.post.review'
    );

    $app->patch('/api/reviews/{id}[/]',
        [
            App\Reviews\Handler\ReviewPatchHandler::class
        ],
        'api.patch.review'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);

    $app->delete('/api/reviews/{id}[/]',
        [
            App\Reviews\Handler\ReviewDeleteHandler::class
        ],
        'api.delete.review'
    )->setOptions([
        'tokens' => [
            'id' => '\w\d+',
        ],
    ]);
};
