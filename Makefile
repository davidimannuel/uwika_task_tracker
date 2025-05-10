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