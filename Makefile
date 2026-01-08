include .env
DOCKER_COMPOSE=docker compose

.ONESHELL:
.PHONY: help

H1=echo === ${1} ===
BR=echo
TAB=echo "\t"

help:
	@$(call H1,Application)
	$(TAB) make install - Собрать и запустить образы, composer install, создание тестовой БД.
	$(TAB) make up - Запуск контейнеров.
	$(TAB) make down - Остановить и удалить контейнеры.
	$(TAB) make update - Пересобрать и перезапустить образы, composer install.
	$(TAB) make php-test - Выполнить все PHP проверки.
	$(TAB) make php-cli - Bash PHP контейнера.
	$(TAB) make php-log - Логи PHP контейнера.
	$(TAB) make php-run CMD="php artisan migrate" - Выполнить команду в PHP контейнере.

install:
	[ -f .env ] || cp .env.example .env
	mkdir -p backend/storage/temp/phpunit || true
	[ -f backend/database/storage/database.sqlite ] || touch backend/database/storage/database.sqlite
	[ -f backend/database/storage/database_test.sqlite ] || touch backend/database/storage/database_test.sqlite
	${DOCKER_COMPOSE} build --no-cache
	${DOCKER_COMPOSE} up -d
	[ -f backend/.env ] || cp backend/.env.example backend/.env
	[ -f backend/.env.testing ] || cp backend/.env.example backend/.env.testing
	${DOCKER_COMPOSE} exec php-dev composer install
	${DOCKER_COMPOSE} exec php-dev php artisan key:generate
	sed -i 's/DB_DATABASE=.*/DB_DATABASE=database/storage/database_test.sqlite/' backend/.env.testing

up:
	${DOCKER_COMPOSE} up -d

down:
	${DOCKER_COMPOSE} down

update:
	${DOCKER_COMPOSE} down
	git pull
	${DOCKER_COMPOSE} build
	${DOCKER_COMPOSE} up -d
	${DOCKER_COMPOSE} exec php-dev composer install

php-test:
	${DOCKER_COMPOSE} exec php-dev composer fix
	${DOCKER_COMPOSE} exec php-dev composer test

php-cli:
	${DOCKER_COMPOSE} exec -it php-dev bash

php-log:
	${DOCKER_COMPOSE} logs php-dev

php-run:
	${DOCKER_COMPOSE} exec php-dev $(CMD)
