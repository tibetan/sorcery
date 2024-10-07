<?php

declare(strict_types=1);

namespace App\Reviews\Handler;

use Common\Exception\NotFoundException;
use App\Reviews\Entity\Reviews;
use App\Reviews\Storage\ReviewsStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReviewGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected ReviewsStorage $reviewsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $review = $this->reviewsStorage->findOne(['_id' => (string) new ObjectId($request->getAttribute('id'))]);

        if (!$review instanceof Reviews) {
            throw NotFoundException::entity('Not found review', ['id' => $request->getAttribute('id')]);
        }

        $resource = $this->resourceGenerator->fromObject($review, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
