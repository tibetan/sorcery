<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Container\ConfigInterface;
use Common\Middleware\LoggerMiddleware;
use Laminas\Log;
use Psr\Container\ContainerInterface;

class LoggerMiddlewareFactory
{
    public const WRITER_STDERR = 'stderr';
    public const WRITER_OUTPUT = 'output';
    public const WRITER_SYSLOG = 'syslog';

    public function __invoke(ContainerInterface $container): LoggerMiddleware
    {
        $callable = function ($requestId, bool $debugEnableHeader, bool $disableLogging) use ($container) {
            $config = $container->get(ConfigInterface::class);
            $logger = new Log\Logger();

            /* registration error handler */
            if (($className = $config->get('error-handler.writer'))) {
                    $parameters = $config->get('error-handler.parameters', []);
                    $writer = new $className(...$parameters);

                $logger->addWriter($writer);
                Log\Logger::registerErrorHandler($logger);
            }

            if (($className = $config->get('logging.writer')) && $disableLogging === false) {
                $parameters = $config->get('logging.parameters', []);
                $writer = new $className(...$parameters);
            } else {
                $writer = new Log\Writer\Stream('php://stderr');
            }

            /* add filters with log levels */
            /* log all levels more or equal than INFO. Without DEBUG level */
            $filter = new Log\Filter\Priority(Log\Logger::INFO);
            if ($debugEnableHeader === true) {
                /* log all levels with DEBUG */
                $filter = new Log\Filter\Priority(Log\Logger::DEBUG);
            }
            $writer->addFilter($filter);

            $formatter = new Log\Formatter\Json();
            $writer->setFormatter($formatter);

            $processor = new Log\Processor\ReferenceId();
            if ($requestId) {
                $processor->setReferenceId($requestId);
            }

            $logger->addProcessor($processor);
            $logger->addWriter($writer);

            return new Log\PsrLoggerAdapter($logger);
        };

        return new LoggerMiddleware($callable, $container);
    }
}
