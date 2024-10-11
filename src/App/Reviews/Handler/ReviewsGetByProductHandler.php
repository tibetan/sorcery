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

class ReviewsGetByProductHandler implements RequestHandlerInterface
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
        $productId = $request->getAttribute('product_id');
        $product = $this->productsStorage->findOne(['_id' => $productId]);

        if (!$product) {
            throw NotFoundException::entity('Product for Reviews not found', ['product_id' => $productId]);
        }

        $filter = [
            'product_id' => $productId,
        ];

        $page = $request->getQueryParams()['page'] ?? 1;
        $limit = $request->getQueryParams()['limit'] ?? 50;

        $reviewsCollection = $this->reviewsStorage->findAll($filter);
        $reviewsCollection->setItemCountPerPage($limit);
        $reviewsCollection->setCurrentPageNumber($page);

        try {
            $resource = $this->resourceGenerator->fromObject($reviewsCollection, $request);
            return $this->responseFactory->createResponse($request, $resource);
        } catch (ResourceGenerator\Exception\OutOfBoundsException $e) {
            throw NotFoundException::collection($e->getMessage(), ['reviewsCollection' => $request->getAttributes()]);
        }
    }
}
