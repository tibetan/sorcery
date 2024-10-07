<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Exception\CriticalException;
use Common\Container\ConfigInterface;
use Interop\Container\ContainerInterface;
use MongoDB\Client;
use MongoDB\Database;
use Mezzio\Hal\ResourceGenerator;

class MongoDatabaseFactory
{
    public function __invoke(ContainerInterface $container): Database
    {
        $config = $container->get(ConfigInterface::class);
        $client = new Client(
            $config->get('mongodb.uri'),
            $config->get('mongodb.options'),
            $config->get('mongodb.driverOptions')
        );

        try {
            $database = $client->selectDatabase($config->get('mongodb.database'));
            if (isset($_ENV['MONGODB_PROFILING']) && (int)$_ENV['MONGODB_PROFILING']!=0 ) {
                $database->command(['profile' => (int)$_ENV['MONGODB_PROFILING']]);
            }
        } catch (ResourceGenerator\Exception\OutOfBoundsException $e) {
            throw CriticalException::noConnectionMongodb($e->getMessage(), ['connection_data' => $config->get('mongodb')]);
        }
        return $database;
    }
}
