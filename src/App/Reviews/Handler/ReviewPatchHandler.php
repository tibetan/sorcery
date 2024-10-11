<?php

declare(strict_types=1);

namespace App\Reviews\Handler;

use App\Reviews\Entity\Reviews;
use App\Reviews\Storage\ReviewsStorage;
use Common\Exception\NotFoundException;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReviewPatchHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory,
        private readonly ReviewsStorage $reviewsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $review = $this->reviewsStorage->findOne(['_id' => new ObjectId($id)]);

        if (!$review instanceof Reviews) {
            throw NotFoundException::entity('Not found review', ['id' => $id]);
        }

        $data = $request->getParsedBody();
        $update = [
            '$set' => $data,
            '$currentDate' => ['updated_at' => true],
        ];

        $this->reviewsStorage->updateOne($review, $update);

        $resource = $this->resourceGenerator->fromObject($review, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(200);
    }
}
