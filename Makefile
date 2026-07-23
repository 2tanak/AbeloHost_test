start:
	@clear
	docker-compose down
	docker-compose up -d --build
	docker-compose exec php-fpm composer install
	
composer_update:
	docker compose exec php-fpm composer dump-autoload	
