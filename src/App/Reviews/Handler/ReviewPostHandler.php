<?php

declare(strict_types=1);

namespace App\Reviews\Handler;

use Common\Exception\NotFoundException;
use App\Reviews\Entity\Reviews;
use App\Reviews\Storage\ReviewsStorage;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReviewPostHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory,
        private readonly ReviewsStorage $reviewsStorage,
        private readonly ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $productId = $data['product_id'];
        $product = $this->productsStorage->findOne(['_id' => $productId]);

        if (!$product) {
            throw NotFoundException::entity('Product not found', ['product_id' => $productId]);
        }

        $review = new Reviews();
        $review->bsonUnserialize($data);

        $this->reviewsStorage->insertOne($review);

        $resource = $this->resourceGenerator->fromObject($review, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(201);
    }
}
