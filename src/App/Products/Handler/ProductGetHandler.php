<?php

declare(strict_types=1);

namespace App\Products\Handler;

use App\Exception\NotFoundException;
use App\Products\Entity\Products;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $product = $this->productsStorage->findOne(['_id' => new ObjectId($request->getAttribute('id'))]);
        if (!$product instanceof Products) {
            throw NotFoundException::entity('Not found product', ['id' => $request->getAttribute('id')]);
        }

        $resource = $this->resourceGenerator->fromObject($product, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}