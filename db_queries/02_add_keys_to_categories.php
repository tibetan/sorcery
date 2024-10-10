<?php

declare(strict_types=1);

require 'vendor/autoload.php';
require '_connect_to_mongo.php';

$mongo = connectToMongo();

/* Create categories collection */
$collection = $mongo->createCollection('categories');
if (!$collection instanceof \MongoDB\Collection) {
    $collection = $mongo->selectCollection('categories');
}
$collection->createIndex(['slug' => 1], ['unique' => true]);
$collection->createIndex(['name' => 1], ['unique' => true]);
