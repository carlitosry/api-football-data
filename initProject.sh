#!/bin/bash

source .env

docker-compose up -d
docker-compose restart
docker-compose exec app composer install
docker-compose exec app su - www-data -s /bin/bash -c 'env' | grep PHP_MEMORY_LIMIT
docker-compose exec app php bin/console doctrine:schema:create
docker-compose exec app php bin/console doctrine:fixture:load --no-interaction
docker-compose exec app php bin/console app:load:csv data/data.csv
docker-compose exec app php bin/console app:tokens:available

echo "*** This API is ready to use! Visit http://localhost:$APP_PORT ***"

exit 0
