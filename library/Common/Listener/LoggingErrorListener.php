<?php

declare(strict_types=1);

namespace Common\Listener;

use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;

class LoggingErrorListener
{
    public function __invoke(Throwable $error, ServerRequestInterface $request, ResponseInterface $response)
    {
        $logger = $request->getAttribute(LoggerInterface::class);

        if ($error instanceof ProblemDetailsExceptionInterface) {
            /* Exception has toArray method */
            $logger->log($this->getLogLevel($error), $error->getMessage(), $error->toArray());
        } else {
            /* Logging all trace from throwable */
            $logger->log($this->getLogLevel($error), $error->getMessage(), $error->getTrace());
        }
    }

    protected function getLogLevel(Throwable $error): string
    {
        $logLevel = LogLevel::CRITICAL;
        $reflectionClass = new \ReflectionClass($error);
        $constantVariable = $reflectionClass->getConstant('LOG_LEVEL');
        if ($constantVariable) {
            $logLevel = $constantVariable;
        }
        return $logLevel;
    }
}
