#!/usr/bin/env bash
DOCKER_GITLAB_USER=$1
DOCKER_GITLAB_PASS=$2
FILE_PATH=$3

rm ./.env.production
rm ./.env.staging
rm ./.env.beta
rm ./.env.release

CURRENT_PATH=$PWD
echo $PWD
if [ -z "$(ls ${CURRENT_PATH}/local-scripts/tmp/ | grep env)" ]; then
    git clone --depth=1 http://${DOCKER_GITLAB_USER}:${DOCKER_GITLAB_PASS}@gitlab.eddev.cf:10087/master/configs.git ./local-scripts/tmp/env;
else
    cd ${CURRENT_PATH}/local-scripts/tmp/;
    git pull -f http://${DOCKER_GITLAB_USER}:${DOCKER_GITLAB_PASS}@gitlab.eddev.cf:10087/master/configs.git master;
    cd ${CURRENT_PATH}
fi;

cp ${CURRENT_PATH}/local-scripts/tmp/env/${FILE_PATH} ./
rm -rf ${CURRENT_PATH}/local-scripts/tmp/env
