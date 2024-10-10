<?php

declare(strict_types=1);

namespace App\Categories\Handler;

use App\Categories\Entity\Categories;
use App\Categories\Storage\CategoriesStorage;
use Common\Exception\ValidationException;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Laminas\Hydrator\ClassMethodsHydrator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoryPostHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ResourceGenerator $resourceGenerator,
        protected HalResponseFactory $responseFactory,
        protected CategoriesStorage $categoriesStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        if (!isset($data['slug'])) {
            throw ValidationException::emptyParameters('Not found \'slug\' field.');
        }

        if (!isset($data['name'])) {
            throw ValidationException::emptyParameters('Not found \'name\' field.');
        }

        $hydrator = new ClassMethodsHydrator();
        $category = $hydrator->hydrate($data, new Categories());

        $this->categoriesStorage->insertOne($category);

        $resource = $this->resourceGenerator->fromObject($category, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(201);
    }
}
