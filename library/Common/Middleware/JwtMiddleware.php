<?php

declare(strict_types=1);

namespace Common\Middleware;

use Common\Container\ConstantInterface;
use Common\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtMiddleware implements MiddlewareInterface
{
    protected $jwtFactory;

    public function __construct(callable $jwtFactory)
    {
        $this->jwtFactory = $jwtFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = $request->getHeader('authorization');

        if (empty($authorization)) {
            throw UnauthorizedException::errorHeader('Not exist header: authorization');
        }

        if (strtolower(substr($authorization[0], 0, 6)) != 'bearer') {
            throw UnauthorizedException::errorHeader('Invalid authorization type. Must be Authorization: Bearer JWT');
        }

        try {
            $token = ($this->jwtFactory)(
                count($authorization) == 1 ? substr($authorization[0], 7) : null,
            );
        } catch (\Throwable $exception) {
            throw UnauthorizedException::unknownJwt($exception->getMessage());
        }

        return $handler->handle(
            $request->withAttribute(
                ConstantInterface::MIDDLEWARE_JWT,
                $token->claims()
            )
        );
    }
}
