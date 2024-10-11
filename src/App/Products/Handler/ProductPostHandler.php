<?php

declare(strict_types=1);

namespace App\Products\Handler;

use App\Products\Entity\Products;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductPostHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory,
        private readonly ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $product = new Products();
        $product->bsonUnserialize($data);

        $this->productsStorage->insertOne($product);

        $resource = $this->resourceGenerator->fromObject($product, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(201);
    }
}
