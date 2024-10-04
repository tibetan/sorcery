<?php

declare(strict_types=1);

namespace App\Products\Handler;

use App\Products\Storage\ProductsStorage;
use Common\Exception\NotFoundException;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductDeleteHandler implements RequestHandlerInterface
{
    public function __construct(
        protected ProductsStorage $productsStorage
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $response = $this->productsStorage->deleteOne(['_id' => $id]);

        return ($response->getDeletedCount() > 0)
            ? new EmptyResponse(204, ['Content-Type' => 'application/hal+json'])
            : throw NotFoundException::entity('Can not delete a product', ['id' => $id]);
    }
}
