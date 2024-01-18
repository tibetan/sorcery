<?php

declare(strict_types=1);

namespace App\Products\Handler;

use Common\Exception\NotFoundException;
use App\Products\Storage\ProductsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductsGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $limit = $request->getQueryParams()['limit'] ?? 50;


        $productsCollection = $this->productsStorage->findAll();
        $productsCollection->setItemCountPerPage($limit);
        $productsCollection->setCurrentPageNumber($page);

        try {
            $resource = $this->resourceGenerator->fromObject($productsCollection, $request);
            return $this->responseFactory->createResponse($request, $resource);
        } catch (ResourceGenerator\Exception\OutOfBoundsException $e) {
            throw NotFoundException::collection($e->getMessage(), ['productsCollection' => $request->getAttributes()]);
        }
    }
}
