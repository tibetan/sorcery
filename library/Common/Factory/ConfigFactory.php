<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Container\Config;
use Common\Container\ConfigInterface;
use Psr\Container\ContainerInterface;

class ConfigFactory
{
    /**
     * @param ContainerInterface $container
     * @return ConfigInterface
     */
    public function __invoke(ContainerInterface $container): ConfigInterface
    {
        $config = $container->get('config');
        return new Config($config);
    }
}
