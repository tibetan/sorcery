<?php

declare(strict_types=1);

use Laminas\Log;

/**
 * Write to the file
 * 'writer' => Laminas\Log\Writer\Stream::class,
 * 'parameters' => ['data/log']
 *
 * Write to the stream
 * 'writer' => Laminas\Log\Writer\Stream::class,
 * 'parameters' => ['php://output']
 *
 * Write to the stderr
 * 'writer' => Laminas\Log\Writer\Stream::class,
 * 'parameters' => ['php://stderr']
 *
 * Write to Syslog
 * 'writer' => Laminas\Log\Writer\Syslog::class,
 * 'parameters' => []
 *
 * Write to graylog
 * 'writer' => \Common\Log\Writer\Graylog::class,
 * 'parameters' => [\Common\Log\Writer\Graylog::TRANSPORT_UDP, $_ENV['GRAYLOG_HOST'], $_ENV['GRAYLOG_PORT']]
 *
 * Enabling error handler can to log PHP errors and intercept exceptions and write it to stderr.
 * Recommend errors log to stderr or syslog
 *
 * 'error-handler' => [
 *   'writer' => Log\Writer\Stream::class,
 *   'parameters' => ['php://stderr'],
 * ]
 */
return [
//    'logging' => [
//        'writer' => \Common\Log\Writer\Graylog::class,
//        'parameters' => [\Common\Log\Writer\Graylog::TRANSPORT_UDP, $_ENV['GRAYLOG_HOST'], $_ENV['GRAYLOG_PORT']]
//    ], // TODO when done Graylog
    'error-handler' => [
        'writer' => Log\Writer\Stream::class,
        'parameters' => ['php://stderr'],
    ]
];
