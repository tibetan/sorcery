<?php

declare(strict_types=1);

namespace App\Categories\Handler;

use App\Categories\Storage\CategoriesStorage;
use Common\Exception\NotFoundException;
use Laminas\Diactoros\Response\EmptyResponse;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoryDeleteHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly CategoriesStorage $categoriesStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $response = $this->categoriesStorage->deleteOne(['_id' => new ObjectId($id)]);

        return ($response->getDeletedCount() > 0)
            ? new EmptyResponse(204, ['Content-Type' => 'application/hal+json'])
            : throw NotFoundException::entity('Can not delete a category', ['id' => $id]);
    }
}
