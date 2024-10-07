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

    $app->post('/api/reviews[/]',
        [
            App\Reviews\Handler\ReviewPostHandler::class
        ],
        'api.post.review'
    );
};
