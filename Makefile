drebuild: dstop dbuild
dbuild:
	docker compose build && docker compose up -d
dstop: 
	docker compose down && docker volume prune -f
dmigrate: 
	docker compose exec app php artisan migrate:fresh --seed
migrate: 
	php artisan migrate:fresh --seed
dlink: 
	docker compose exec app php artisan storage:link
link: 
	php artisan storage:link
