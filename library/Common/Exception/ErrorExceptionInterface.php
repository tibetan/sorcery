<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface ErrorExceptionInterface
{
    public const LOG_LEVEL = LogLevel::ERROR;
}
