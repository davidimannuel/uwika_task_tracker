run:
	php artisan serve

run-npm:
	npm run dev

migrate:
	php artisan migrate

migrate-fresh:
	php artisan migrate:fresh

migrate-fresh-seed:
	php artisan migrate:fresh --seed

docker-run-dev:
	docker compose -f compose.dev.yaml up --build -d

build-vite:
	npm run build

docker-migrate-dev:
	docker-compose -f compose.dev.yaml exec php-fpm php artisan migrate

docker-stop-dev:
	docker compose -f compose.dev.yaml down

docker-run-prod:
	docker compose -f compose.prod.yaml down
	docker compose -f compose.prod.yaml up --build -d