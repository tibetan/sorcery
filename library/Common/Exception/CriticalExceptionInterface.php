<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface CriticalExceptionInterface
{
    public const LOG_LEVEL = LogLevel::CRITICAL;
}
