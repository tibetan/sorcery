<?php

declare(strict_types=1);

namespace Common\Handler;

use Common\Container\ConfigInterface;
use Common\Diagnostics\Runner\Reporter\ExecutionTimeReporter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Diagnostics\Result\FailureInterface;
use Laminas\Diagnostics\Runner\Runner;

class MetricsHandler implements RequestHandlerInterface
{
    private const PROMETHEUS_NAME = '%s_%s_%s_%s{environment="%s", uid="%s", response="%s"} %d';

    protected ConfigInterface $config;
    protected Runner $runner;

    public function __construct(Runner $runner, ConfigInterface $config)
    {
        $this->runner = $runner;
        $this->config = $config;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->runner->addReporter(new ExecutionTimeReporter());
        $results = $this->runner->run();

        $environment = $_ENV['ENVIRONMENT'];
        $uid = $_ENV['UID'];

        $strings[] = sprintf(
            '%s_http_life{environment="%s", uid="%s", response="Ok"} 1',
            $this->config->get('prometheus.serviceName'),
            $environment,
            $uid
        );

        foreach ($this->runner->getChecks() as $checkerName => $checkerClass) {
            $strings[] = sprintf(
                self::PROMETHEUS_NAME,
                $this->config->get('prometheus.serviceName'),
                $this->config->get('diagnostics.' . $checkerName . '.prefix'),
                $checkerName,
                $this->config->get('diagnostics.' . $checkerName . '.suffix'),
                $environment,
                $uid,
                $results[$checkerClass] instanceof FailureInterface ? $results[$checkerClass]->getMessage() : 'Ok',
                $results[$checkerClass] instanceof FailureInterface ? 0 : 1
            );
        }

        return new TextResponse(implode("\n", $strings));
    }
}
