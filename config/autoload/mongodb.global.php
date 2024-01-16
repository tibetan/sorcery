<?php

declare(strict_types=1);

return [
    'mongodb' => [
        'uri' => $_ENV['MONGODB_URI'] ?? 'mongodb://localhost:27017',
        'options' => $_ENV['MONGODB_OPTIONS'] ?? [],
        'driverOptions' => $_ENV['MONGODB_DRIVER_OPTIONS'] ?? [],
        'database' => $_ENV['MONGODB_DATABASE'] ?? 'sorcery',
    ]
];
