<?php

declare(strict_types=1);

namespace Common\Diagnostics\Runner\Reporter;

use ArrayObject;
use Laminas\Diagnostics\Check\CheckInterface;
use Laminas\Diagnostics\Result\Collection as ResultsCollection;
use Laminas\Diagnostics\Result\ResultInterface;
use Laminas\Diagnostics\Runner\Reporter\ReporterInterface;

class ExecutionTimeReporter implements ReporterInterface
{
    private array $timer = [];

    public function onStart(ArrayObject $checks, $runnerConfig)
    {
        // TODO: Implement onFinish() method.
    }

    public function onBeforeRun(CheckInterface $check, $checkAlias = null)
    {
        $this->timer[$checkAlias] = microtime(true);
    }

    public function onAfterRun(CheckInterface $check, ResultInterface $result, $checkAlias = null)
    {
        $endTime = microtime(true);
        $this->timer[$checkAlias] = $endTime - $this->timer[$checkAlias];
        $result->setData($this->timer[$checkAlias]);
    }

    public function onStop(ResultsCollection $results)
    {
        // TODO: Implement onFinish() method.
    }

    public function onFinish(ResultsCollection $results)
    {
        // TODO: Implement onFinish() method.
    }
}
