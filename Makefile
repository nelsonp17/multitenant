build:
	docker build -t php-fpm-multitenant .
	#docker-compose build

up:
	#docker compose -f docker-compose up -d
	docker compose -f docker-compose.yml up -d php-fpm nginx --build db
	#docker-compose up -d
	docker run -p 3306:3306 -e MYSQL_ROOT_PASSWORD=1234 mysql:latest
	docker exec -it mysql-multitenant bash
	docker run --name phpmyadmin -d -e PMA_ARBITRARY=1 -p 8080:80 phpmyadmin
	docker run --name mysql-multitenant -e MYSQL_ROOT_PASSWORD=1234 -d mysql:latest --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
	docker exec -it a94cd9e6544a mysql -p
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "php artisan migrate"

	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "composer install --ignore-platform-req=ext-http"

compose_install:
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "composer install"
migrate:
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "php artisan migrate"
npm_dev:
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "npm run dev"
npm_build:
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "npm run build"
deps:
	docker exec -it mysql-multitenant bash

	docker exec -u root -i php-fpm-multitenant /bin/sh -c "chown -R lempdock:www-data /var/www/*"
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "chmod -R g+rw /var/www/*"

down:
	#docker compose -f docker-compose down
	docker-compose down
restart:
	#docker compose docker-compose restart
	docker-compose restart
logs:
	#docker compose docker-compose logs -f
	docker-compose logs -f

shell:
	#docker compose docker-compose exec app bash
	docker-compose exec app bash

perms:
	docker exec -u root -i php-fpm-multitenant /bin/sh -c "chown -R www-data /var/www/*"
	docker exec -u 1000 -i php-fpm-multitenant /bin/sh -c "chmod -R g+rw /var/www/*"
