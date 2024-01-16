<?php

declare(strict_types=1);

namespace Common\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class LoggerMiddleware implements MiddlewareInterface
{
    /**
     * @var callable
     */
    protected $logger;
    protected ContainerInterface $container;

    public function __construct(callable $logger, ContainerInterface $container)
    {
        $this->logger = $logger;
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestId = $request->getHeader('X-Request-Id');
        $debugging = $request->getHeader('X-Debugging');
        $logging = $request->getHeader('X-Logging');

        $logger = ($this->logger)(
            count($requestId) == 1 ? $requestId[0] : null,
            (count($debugging) == 1 && $debugging[0] == 'on'),
            (count($logging) == 1 && $logging[0] == 'off')
        );

        /* Add logger to container */
        $this->container->setService(LoggerInterface::class, $logger);

        return $handler->handle(
            $request->withAttribute(
                LoggerInterface::class,
                $logger
            )
        );
    }
}
