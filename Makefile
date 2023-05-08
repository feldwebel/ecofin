include .env

init:
	docker-compose exec db psql postgresql://${DB_USER}:${DB_PASS}@localhost:5432/${DB_NAME} -f /docker-entrypoint-initdb.d/dump.sql
	docker-compose exec php composer.phar install