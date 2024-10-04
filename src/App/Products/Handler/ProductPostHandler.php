<?php

declare(strict_types=1);

namespace App\Products\Handler;

use App\Products\Entity\Products;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Laminas\Hydrator\ClassMethodsHydrator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductPostHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $hydrator = new ClassMethodsHydrator();
        $dateTime = new \DateTime();

        $product = $hydrator->hydrate($data, new Products());
        $product->setId((string) new ObjectId());
        $product->setCreatedAt($dateTime);
        $product->setUpdatedAt($dateTime);

        $this->productsStorage->insertOne($product);

        $resource = $this->resourceGenerator->fromObject($product, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(201);
    }
}
