<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface EmergencyExceptionInterface
{
    public const LOG_LEVEL = LogLevel::EMERGENCY;
}
