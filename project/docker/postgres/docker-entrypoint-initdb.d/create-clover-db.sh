#!/bin/bash

psql -v ON_ERROR_STOP=1 --username "cloveruser" --dbname "cloverdb" --password "cloverpassword" <<-EOSQL
    SET statement_timeout = 0;
    SET lock_timeout = 0;

    --  Personal users
    CREATE USER vova WITH PASSWORD '12';
    GRANT admin TO vova;

    CREATE ROLE readonly;
    CREATE ROLE readwrite;
    CREATE ROLE cloveruserapp;
    CREATE ROLE mainusever NOINHERIT;
    CREATE ROLE admin;

    CREATE ROLE cloverdb_readonly NOINHERIT;
    CREATE ROLE cloverdb_readwrite NOINHERIT;

    GRANT cloverdb_readwrite TO admin;
    DROP user cloveruserapp;

    GRANT readonly TO admin;
    GRANT readwrite TO admin;
    GRANT mainusever TO admin;

    CREATE USER "cloveruserapp" WITH PASSWORD '41cc9fd2d209276859d9';

    ALTER DATABASE "public.cloverdb" SET geqo TO off;
    REVOKE ALL ON DATABASE "public.cloverdb" FROM public;

    GRANT CONNECT ON DATABASE "cloverdb" TO cloveruser;
    GRANT CONNECT ON DATABASE "cloverdb" TO cloveruserapp;
    GRANT CONNECT ON DATABASE "cloverdb" TO admin;
EOSQL