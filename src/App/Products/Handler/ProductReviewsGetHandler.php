<?php

declare(strict_types=1);

namespace App\Products\Handler;

use Common\Exception\NotFoundException;
use App\Products\Entity\Products;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductReviewsGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $filter = [
            '_id' => $request->getAttribute('id'),
        ];

        $options = [];

        $product = $this->productsStorage->findOneWithReviews($filter, $options);

        if (!$product instanceof Products) {
            throw NotFoundException::entity('Not found product', ['id' => $request->getAttribute('id')]);
        }

        $resource = $this->resourceGenerator->fromObject($product, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
