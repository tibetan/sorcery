<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface AlertExceptionInterface
{
    public const LOG_LEVEL = LogLevel::ALERT;
}
