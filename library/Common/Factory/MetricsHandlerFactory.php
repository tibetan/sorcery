<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Container\ConfigInterface;
use Interop\Container\ContainerInterface;
use Common\Handler\MetricsHandler;
use Laminas\Diagnostics\Runner\Runner;

class MetricsHandlerFactory
{
    public function __invoke(ContainerInterface $container): MetricsHandler
    {
        $config = $container->get(ConfigInterface::class);
        $runner = $container->get(Runner::class);

        foreach ($config->get('diagnostics') as $checkerName => $parameters) {
            if (is_object($parameters['checker'])) {
                $runner->addCheck($parameters['checker'], $checkerName);
            } else {
                $className = $parameters['checker'];
                $runner->addCheck(new $className(...$parameters['parameters']), $checkerName);
            }
        }

        return new MetricsHandler($runner, $config);
    }
}
