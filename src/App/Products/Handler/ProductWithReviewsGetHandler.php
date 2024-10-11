<?php

declare(strict_types=1);

namespace App\Products\Handler;

use Common\Exception\NotFoundException;
use App\Products\Entity\Products;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductWithReviewsGetHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory,
        private readonly ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $productId = $request->getAttribute('id');
        $filter = [
            '_id' => new ObjectId($productId)
        ];
        $options = [];
        $product = $this->productsStorage->findOneWithReviews($filter, $options);

        if (!$product instanceof Products) {
            throw NotFoundException::entity('Not found product', ['id' => $productId]);
        }

        $resource = $this->resourceGenerator->fromObject($product, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
