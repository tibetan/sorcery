<?php

declare(strict_types=1);

namespace Common;

use Common\Listener;
use Common\Middleware;
use Laminas\Diagnostics\Runner\Runner;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;
use MongoDB\Database;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array{"dependencies": string[][][]}
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array{"invokables": string[], "factories": string[], "delegators": string[][]}
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Runner::class => Runner::class,
                Listener\LoggingErrorListener::class => Listener\LoggingErrorListener::class,
            ],
            'factories'  => [
                Container\ConfigInterface::class => Factory\ConfigFactory::class,
                Handler\MetricsHandler::class => Factory\MetricsHandlerFactory::class,
                Middleware\LoggerMiddleware::class => Factory\LoggerMiddlewareFactory::class,
//                Middleware\JwtMiddleware::class => Factory\JwtMiddlewareFactory::class,
                Database::class => Factory\MongoDatabaseFactory::class,
            ],
            'delegators' => [
                ProblemDetailsMiddleware::class => [
                    Factory\ErrorHandlerLoggingDelegatorFactory::class,
                ]
            ]
        ];
    }
}
