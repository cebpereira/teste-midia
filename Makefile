setup:
	@make build
	@make up
	@make composer-update
	@make key
	@make data
	@make link

build:
	docker compose build --no-cache --force-rm

stop:
	docker compose stop

up:
	docker compose up -d

composer-update:
	docker exec teste-midia-site bash -c "composer update"

data:
	docker exec teste-midia-site bash -c "php artisan migrate"
	docker exec teste-midia-site bash -c "php artisan db:seed"

key:
	docker exec teste-midia-site bash -c "php artisan key:generate"

link:
	docker exec teste-midia-site bash -c "php artisan storage:link"
