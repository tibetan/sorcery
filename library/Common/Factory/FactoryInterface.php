<?php

namespace Common\Factory;

use Common\Storage\StorageInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface FactoryInterface
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface | StorageInterface;
}
