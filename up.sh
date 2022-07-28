#!/usr/bin/env bash

set -o errexit
set -o pipefail

docker network ls|grep car-api > /dev/null || docker network create car-api
docker volume ls|grep car-api-database > /dev/null || docker volume create --name=car-api-database
docker-compose --project-name car-api-app \
		up --detach \
		--force-recreate \
		--build

docker exec -it car-api-app_app_1 chown -R www-data:www-data storage
echo "Created Car-api App"
