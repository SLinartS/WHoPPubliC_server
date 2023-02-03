rebuild:
	docker compose down && docker compose build && docker compose up -d
migratedb:
	docker-compose exec app php artisan migrate:fresh --seed