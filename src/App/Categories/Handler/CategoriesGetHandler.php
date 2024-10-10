<?php

declare(strict_types=1);

namespace App\Categories\Handler;

use Common\Exception\NotFoundException;
use App\Categories\Storage\CategoriesStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoriesGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected CategoriesStorage $categoriesStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $limit = $request->getQueryParams()['limit'] ?? 50;


        $categoriesCollection = $this->categoriesStorage->findAll();
        $categoriesCollection->setItemCountPerPage($limit);
        $categoriesCollection->setCurrentPageNumber($page);

        try {
            $resource = $this->resourceGenerator->fromObject($categoriesCollection, $request);
            return $this->responseFactory->createResponse($request, $resource);
        } catch (ResourceGenerator\Exception\OutOfBoundsException $e) {
            throw NotFoundException::collection(
                $e->getMessage(),
                ['categoriesCollection' => $request->getAttributes()]
            );
        }
    }
}
