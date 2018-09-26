# docker run --rm -v $(pwd):/app composer/composer install
setup:
	docker run --rm -v $(CURDIR):/app composer/composer install
	docker-compose up -d --build
	docker-compose run --rm nodejs npm install
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan optimize

dc-up:
	docker-compose up --build -d

dc-down:
	docker-compose down

dc-ps:
	docker-compose ps

dc-bash:
	docker-compose exec app bash

dc-migrate:
	docker-compose exec app bash -c "php artisan migrate -v"

dc-seeding:
	docker-compose exec app bash -c "php artisan db:seed"

dc-cache-clear:
	docker-compose exec app bash -c "php artisan cache:clear"
