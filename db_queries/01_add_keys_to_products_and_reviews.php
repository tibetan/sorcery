<?php

declare(strict_types=1);

//ini_set("memory_limit", "-1");
//set_time_limit(0);

require 'vendor/autoload.php';

$mongo = connectToMongo();

/* Create products collection */
$collection = $mongo->createCollection('products');
if (!$collection instanceof \MongoDB\Collection) {
    $collection = $mongo->selectCollection('products');
}
$collection->createIndex(['sku' => 1], ['unique' => true]);

/* Create reviews collection */
$collection = $mongo->createCollection('reviews');
if (!$collection instanceof \MongoDB\Collection) {
    $collection = $mongo->selectCollection('reviews');
}
$collection->createIndex(['product_id' => 1], ['background' => 1]);

function connectToMongo(): \MongoDB\Database
{
    $container = require dirname(__DIR__) . '/config/container.php';
    $config = $container->get('config');

    $client = new \MongoDB\Client($config['mongodb']['uri']);
    return $client->selectDatabase($config['mongodb']['database']);
}
