.DEFAULT_GOAL := help

REGISTRY = registry.gitlab.eddev.cf:5000/master/stv2

WORKSPACE_NO_TTY = docker-compose exec -T --user www-data workspace

ENV_FILE=$(shell ./local-scripts/get_makefile_env.sh)

# Экспорт параметров env файла
include ./${ENV_FILE}
export

GIT_REVISION := GIT_REVISION=`git describe --tags`

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = "Makefile:"} {printf "%s\n", $$1}' | awk 'BEGIN {FS = ":.*##"} {printf "\033[36m%-16s\033[0m %s\n", "make " $$1 , $$2}'

########################################################################################################################

ubuntu-18.04-base: ## Фиксация базово имиджа для nginx
	./local-scripts/images_retag/retag.sh $(REGISTRY) ubuntu 18.04
	docker pull ubuntu:18.04
	docker tag ubuntu:18.04 $(REGISTRY)/ubuntu:18.04
	docker push $(REGISTRY)/ubuntu:18.04

php-7.4-base: ## Фиксация базово имиджа для workspace
	./local-scripts/images_retag/retag.sh $(REGISTRY) php 7.4
	docker pull php:7.4
	docker tag php:7.4 $(REGISTRY)/php:7.4
	docker push $(REGISTRY)/php:7.4

php-7.4-fpm-base: ## Фиксация базово имиджа для php-fpm
	./local-scripts/images_retag/retag.sh $(REGISTRY) php 7.4-fpm
	docker pull php:7.4-fpm
	docker tag php:7.4-fpm $(REGISTRY)/php:7.4-fpm
	docker push $(REGISTRY)/php:7.4-fpm

docker-dind-base: ## Фиксация базового имиджа для my-docker-dind
	./local-scripts/images_retag/retag.sh $(REGISTRY) docker dind
	docker pull docker:dind
	docker tag docker:dind $(REGISTRY)/docker:dind
	docker push $(REGISTRY)/docker:dind

docker-18.06.0-ce-base: ## Фиксация базового имиджа для tmaier
	./local-scripts/images_retag/retag.sh $(REGISTRY) docker 18.06.0-ce
	docker pull docker:18.06.0-ce
	docker tag docker:18.06.0-ce $(REGISTRY)/docker:18.06.0-ce
	docker push $(REGISTRY)/docker:18.06.0-ce

prom-prometheus-v2.0.0-base: ## Фиксация базового имиджа для prometheus
	./local-scripts/images_retag/retag.sh $(REGISTRY) prom/prometheus v2.0.0
	docker pull prom/prometheus:v2.0.0
	docker tag prom/prometheus:v2.0.0 $(REGISTRY)/prom/prometheus:v2.0.0
	docker push $(REGISTRY)/prom/prometheus:v2.0.0

########################################################################################################################

dc-bsp-base-nginx: ## Создание образа nginx для dynamicus без конфигов
	docker pull $(REGISTRY)/ubuntu:18.04
	./local-scripts/images_retag/retag.sh $(REGISTRY) dynamicus-nginx base
	docker build -f nginx/Dockerfile --squash --build-arg ${GIT_REVISION} --build-arg PUID=1000 -t $(REGISTRY)/dynamicus-nginx:base nginx
	docker push $(REGISTRY)/dynamicus-nginx:base

dc-bsp-base-php-fpm: ## Создание образа php-fpm для dynamicus без кода
	docker pull $(REGISTRY)/php:7.4-fpm
	./local-scripts/images_retag/retag.sh $(REGISTRY) dynamicus-php-fpm base
	docker build -f php-fpm/Dockerfile --squash --build-arg ${GIT_REVISION} --build-arg INSTALL_XDEBUG=false --build-arg PHP_CONF=production --build-arg PUID=1000 -t $(REGISTRY)/dynamicus-php-fpm:base php-fpm
	docker push $(REGISTRY)/dynamicus-php-fpm:base

########################################################################################################################

dc-bsp-local-nginx: ## Создание образа nginx для dynamicus без конфигов для локальных окружений
	docker pull $(REGISTRY)/ubuntu:18.04
	./local-scripts/images_retag/retag.sh $(REGISTRY) dynamicus-nginx local
	docker build -f nginx/Dockerfile --squash --build-arg ${GIT_REVISION} --build-arg PUID=1000 -t $(REGISTRY)/dynamicus-nginx:local nginx
	docker push $(REGISTRY)/dynamicus-nginx:local

dc-bsp-local-php-fpm: ## Создание образа php-fpm для dynamicus без кода для локальных окружений
	docker pull $(REGISTRY)/php:7.4-fpm
	./local-scripts/images_retag/retag.sh $(REGISTRY) dynamicus-php-fpm local
	docker build -f php-fpm/Dockerfile --squash --build-arg ${GIT_REVISION} --build-arg INSTALL_XDEBUG=true --build-arg PHP_CONF=local --build-arg PUID=1000 -t $(REGISTRY)/dynamicus-php-fpm:local php-fpm
	docker push $(REGISTRY)/dynamicus-php-fpm:local

########################################################################################################################

dc-bsp-workspace: ## Создание образа workspace для dynamicus
	docker pull $(REGISTRY)/php:7.4
	./local-scripts/images_retag/retag.sh $(REGISTRY) dynamicus-workspace latest
	docker build -f workspace/Dockerfile --build-arg INSTALL_XDEBUG=true --build-arg PUID=1000 -t $(REGISTRY)/dynamicus-workspace:latest workspace
	docker push $(REGISTRY)/dynamicus-workspace:latest

dc-bsp-tmaier: ## https://letsclearitup.com.ua/docker/gitlab-ci-chast-2-spetsialnyie-obrazyi.html
	docker pull $(REGISTRY)/docker:18.06.0-ce
	./local-scripts/images_retag/retag.sh $(REGISTRY) tmaier-dc-ssh latest
	docker build -f service-containers/tmaier.Dockerfile --build-arg ${GIT_REVISION} -t $(REGISTRY)/tmaier-dc-ssh:latest service-containers
	docker push $(REGISTRY)/tmaier-dc-ssh:latest

dc-bsp-dind: ## https://letsclearitup.com.ua/docker/gitlab-ci-chast-2-spetsialnyie-obrazyi.html
	cp ./ssh-key/ca.crt service-containers/ca.crt
	docker pull $(REGISTRY)/docker:dind
	./local-scripts/images_retag/retag.sh $(REGISTRY) my-docker-dind new
	docker build -f service-containers/dind.Dockerfile --build-arg ${GIT_REVISION} -t $(REGISTRY)/my-docker-dind:new  service-containers
	rm service-containers/ca.crt
	docker push $(REGISTRY)/my-docker-dind:new

########################################################################################################################

dc-bsp-prometheus: ## Собрать промежуточный прометеус для сервера статики
	docker pull $(REGISTRY)/prom/prometheus:v2.0.0
	./local-scripts/images_retag/retag.sh $(REGISTRY) prometheus-ed-sq stable
	docker build -f prometheus/Dockerfile --squash --build-arg ${GIT_REVISION} -t $(REGISTRY)/prometheus-ed-sq:stable ./prometheus
	docker push $(REGISTRY)/prometheus-ed-sq:stable

########################################################################################################################

dc-up: ## Запуск локального окружения
	docker-compose up -d --build

dc-down: ## Остановка локального окружения
	docker-compose down

composer-install-dev: ## Выполнить установку php зависимостей (работает на поднятом проекте)
	docker exec -it -u www-data php_sorcery composer install

composer-install-prod: ## Выполнить установку php зависимостей для прода (работает на поднятом проекте)
	docker exec -it -u www-data php_sorcery composer install --no-dev

composer-update-dev: ## Выполнить обновление php зависимостей (работает на поднятом проекте)
	docker exec -it -u www-data php_sorcery composer update

composer-update-prod: ## Выполнить обновление php зависимостей для прода (работает на поднятом проекте)
	docker exec -it -u www-data php_sorcery composer update --no-dev

build-backend: ## Сбилдить backend (работает на поднятом проекте)
	$(WORKSPACE_NO_TTY) sh -c "composer install -vv"

dc-nginx-rules-reload: ## Обновить конфиги nginx локального окружения (работает только на поднятом проекте)
	./nginx/replacer.sh ./nginx/template ./nginx/local ./.env
	docker exec nginx bash -c "nginx -t; nginx -s reload;"

dc-nginx-create-local-rules: ## Создать конфиги nginx для локального окружения
	./nginx/replacer.sh ./nginx/template ./nginx/local ./.env

dc-nginx-create-production-rules: ## Сгенерировать конфиги nginx для прода (для проверки)
	@{ \
    	if [ -z `ls -a ./ | grep .env.production` ]; \
    	then \
    		./local-scripts/get_enviroment_file.sh ${DOCKER_GITLAB_USER} ${DOCKER_GITLAB_PASS} dynamicus/docker/.env.production; \
    		make dc-nginx-create-production-rules DOCKER_GITLAB_USER=${DOCKER_GITLAB_USER} DOCKER_GITLAB_PASS=${DOCKER_GITLAB_PASS}; \
    	else \
    		echo ${SERVER_NAME_BASE}; \
    		./nginx/replacer.sh ./nginx/template ./nginx/production ./.env.production ./nginx/overwrite-production-template; \
    		rm .env.production; \
    		echo "\e[32mDone!\e[0m"; \
    	fi; \
    	}

create-project: ## Подготовка локального окружения при первом запуске
	./nginx/replacer.sh ./nginx/template ./nginx/local ./.env
	docker-compose pull
	docker-compose up -d
	$(WORKSPACE_NO_TTY) sh -c "composer install -vv"

console-workspace: ## Запуск консоли в контейнере workspace
	docker exec -it -u www-data workspace bash