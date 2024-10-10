<?php

declare(strict_types=1);

function connectToMongo(): \MongoDB\Database
{
    $container = require dirname(__DIR__) . '/config/container.php';
    $config = $container->get('config');

    $client = new \MongoDB\Client($config['mongodb']['uri']);
    return $client->selectDatabase($config['mongodb']['database']);
}
