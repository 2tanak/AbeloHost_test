start:
	@clear
	docker-compose down
	docker-compose up -d --build
	docker-compose exec php-fpm composer install
	docker-compose exec node npm i
	docker-compose exec -d node npm run scss:watch
	@echo "Ожидание запуска контейнеров..."
	@sleep 3
	@echo ""
	@echo "========================"
	@echo "  ПРОЕКТ УСПЕШНО ЗАПУЩЕН!"
	@echo "  САЙТ ДОСТУПЕН ПО АДРЕСУ: http://localhost"
	@echo "========================"
	@echo ""
	
	
composer_update:
	docker compose exec php-fpm composer dump-autoload	

node:
	docker compose up -d node