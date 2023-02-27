rebuild:
	docker compose down && docker compose build && docker compose up -d
docmigrate:
	docker-compose exec app php artisan migrate:fresh --seed
migrate: 
	php artisan migrate:fresh --seed
link: 
	php artisan storage:link