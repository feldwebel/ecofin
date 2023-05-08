#!/bin/bash -xe
psql -v ON_ERROR_STOP=1 --username "$DB_USER" --dbname "$DB_NAME" <<-EOSQL
	CREATE USER $DB_USER password '$DB_PASS' superuser;
	CREATE DATABASE $DB_NAME owner $DB_USER LC_COLLATE='ru_RU.UTF-8' LC_CTYPE='ru_RU.UTF-8' TEMPLATE template0;
EOSQL
