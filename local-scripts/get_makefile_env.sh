#!/usr/bin/env bash

#if [[ `ls -a ./ | grep -e .env.staging -e .env.production -e .env.beta -e .env.release | wc -l` > 1 ]]; then
#    rm ./.env.production
#    rm ./.env.staging
#    rm ./.env.beta
#    rm ./.env.release
#fi
#
#if [[ ! -z `ls -a ./ | grep .env.staging` ]]; then
#    echo ".env.staging"
#elif [[ ! -z `ls -a ./ | grep .env.production` ]]; then
#    echo ".env.production"
#elif [[ ! -z `ls -a ./ | grep .env.beta` ]]; then
#    echo ".env.beta"
#elif [[ ! -z `ls -a ./ | grep .env.release` ]]; then
#    echo ".env.release"
#else
#    echo ".env"
#fi

echo ".env"

exit 0