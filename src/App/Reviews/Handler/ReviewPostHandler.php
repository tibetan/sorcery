<?php

declare(strict_types=1);

namespace App\Reviews\Handler;

use App\Reviews\Entity\Reviews;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Laminas\Hydrator\ClassMethodsHydrator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReviewPostHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ReviewsStorage $reviewsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $hydrator = new ClassMethodsHydrator();
        $review = $hydrator->hydrate($data, new Reviews());
        $this->reviewsStorage->insertOne($review);

        $resource = $this->resourceGenerator->fromObject($review, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(201);
    }
}
