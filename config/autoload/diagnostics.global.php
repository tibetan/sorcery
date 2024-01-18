<?php

declare(strict_types=1);

use Laminas\Diagnostics\Check;

return [
    'sorcery' => [
        'serviceName' => $_ENV['SERVICE_NAME'] ?? 'chat',
    ],
    'diagnostics' => [
        /* Name for checker. <prefix>_METRIC_<suffix> */
    ]
];
