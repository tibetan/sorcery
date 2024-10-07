<?php

declare(strict_types=1);

namespace App\Reviews\Handler;

use Common\Exception\NotFoundException;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReviewsGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ReviewsStorage $reviewsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $limit = $request->getQueryParams()['limit'] ?? 50;


        $reviewsCollection = $this->reviewsStorage->findAll();
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
