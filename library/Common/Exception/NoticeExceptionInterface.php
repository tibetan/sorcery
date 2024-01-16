<?php

namespace Common\Exception;

use Psr\Log\LogLevel;

interface NoticeExceptionInterface
{
    public const LOG_LEVEL = LogLevel::NOTICE;
}
