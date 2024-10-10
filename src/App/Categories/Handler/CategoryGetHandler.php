<?php

declare(strict_types=1);

namespace App\Categories\Handler;

use Common\Exception\NotFoundException;
use App\Categories\Entity\Categories;
use App\Categories\Storage\CategoriesStorage;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoryGetHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected CategoriesStorage $categoriesStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $category = $this->categoriesStorage->findOne(['_id' => (string) new ObjectId($request->getAttribute('id'))]);

        if (!$category instanceof Categories) {
            throw NotFoundException::entity('Not found category', ['id' => $request->getAttribute('id')]);
        }

        $resource = $this->resourceGenerator->fromObject($category, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
