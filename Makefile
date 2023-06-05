drebuild: dstop dbuild
dbuild:
	docker compose build && docker compose up -d
dstop: 
	docker compose down && docker volume prune -f
dinit:
	docker compose exec app php artisan optimize:clear \
	&& docker compose exec app php artisan key:generate \
	&& docker compose exec app php artisan migrate:fresh --seed
migrate: 
	php artisan migrate:fresh --seed
link: 
	php artisan storage:link
