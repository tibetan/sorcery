<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface WarningExceptionInterface
{
    public const LOG_LEVEL = LogLevel::WARNING;
}
