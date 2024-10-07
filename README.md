# Installing of the project

## After DB collections will be created

Run scripts from directory `db_queries/`:

```bash
docker compose exec php php db_queries/01_add_keys_to_products_and_reviews.php
...
```

## To create swagger API documentation

```bash
docker compose exec php composer swagger:build
```
for coping needed data from `vendor/` to `public/api/swagger/`,
and

```bash
docker compose exec php composer swagger:deploy
```
for updating all custom files from `swagger/` directory.
Url `api/swagger/` will be available.

These commands run also when install or update composer. 




## Application Development Mode Tool

This project comes with [laminas-development-mode](https://github.com/laminas/laminas-development-mode).
It provides a composer script to allow you to enable and disable development mode.

### To enable development mode

**Note:** Do NOT run development mode on your production server!

```bash
$ composer development-enable
```

**Note:** Enabling development mode will also clear your configuration cache, to
allow safely updating dependencies and ensuring any new configuration is picked
up by your application.

### To disable development mode

```bash
$ composer development-disable
```

### Development mode status

```bash
$ composer development-status
```

## Configuration caching

By default, the skeleton will create a configuration cache in
`data/config-cache.php`. When in development mode, the configuration cache is
disabled, and switching in and out of development mode will remove the
configuration cache.

You may need to clear the configuration cache in production when deploying if
you deploy to the same directory. You may do so using the following:

```bash
$ composer clear-config-cache
```

You may also change the location of the configuration cache itself by editing
the `config/config.php` file and changing the `config_cache_path` entry of the
local `$cacheConfig` variable.

## Run composer

Need to go to the php container and run install/update composer 

```bash
$ docker exec -it --user www-data php_sorcery /bin/bash
$ composer install(/update)
```

**Note:** Please note that the installer tests remove installed config files and templates
before and after running the tests.

Before contributing read [the contributing guide](https://github.com/mezzio/.github/blob/master/CONTRIBUTING.md).

## Copy .env variables with default environment configuration

```bash
$ cp ./.env.example ./.env 
$ cd /public
$ cp .env.example .env 
```
**Note:** After copy need to fill the files .env 

