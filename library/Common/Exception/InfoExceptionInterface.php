<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface InfoExceptionInterface
{
    public const LOG_LEVEL = LogLevel::INFO;
}
