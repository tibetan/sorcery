<?php

declare(strict_types=1);

namespace App\Products\Handler;

use App\Products\Entity\Products;
use App\Products\Storage\ProductsStorage;
use Common\Exception\NotFoundException;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use MongoDB\BSON\ObjectId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductPatchHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory,
        private readonly ProductsStorage $productsStorage,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $product = $this->productsStorage->findOne(['_id' => new ObjectId($id)]);

        if (!$product instanceof Products) {
            throw NotFoundException::entity('Not found product', ['id' => $id]);
        }

        $data = $request->getParsedBody();
        $update = [
            '$set' => $data,
            '$currentDate' => ['updated_at' => true],
        ];

        $this->productsStorage->updateOne($product, $update);

        $resource = $this->resourceGenerator->fromObject($product, $request);

        return $this->responseFactory->createResponse($request, $resource)
            ->withStatus(200);
    }
}
