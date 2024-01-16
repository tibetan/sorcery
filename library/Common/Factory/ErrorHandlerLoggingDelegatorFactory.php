<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Listener\LoggingErrorListener;
use Psr\Container\ContainerInterface;

class ErrorHandlerLoggingDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback)
    {
        $listener = new LoggingErrorListener();
        $repository = $callback();
        $repository->attachListener($listener);
        return $repository;
    }
}
