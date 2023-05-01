# Clover APP

```txt
        email: init@gmail.com
        password: password
```

```bash
        export APP_KEY=$(openssl rand -base64 12)
        docker-compose up -d
        php artisan migrate:fresh && php artisan db:seed 
        curl -XGET -H "X-API-TOKEN 6y21reV9pj2HCDlJlH21FvgSicwrsLjuBRopifEJY4vmBl6rlyXv88txK2Md8CdV" localhost:8000/api/user/companies  
```

```txt
        curl -XPOST localhost:8080/api/user/sign-in -H "content-type: application/json" -d "email=init@gmail.com" -d "password=password"
        curl -X POST http://localhost:8080/api/user/sign-in \
           -H "Content-Type: application/json"  \
           -H "Accept: application/json"    \
           -d '{"email": "init@gmail.com", "password": "password"}'

        curl -XGET -H "X-API-TOKEN 6y21reV9pj2HCDlJlH21FvgSicwrsLjuBRopifEJY4vmBl6rlyXv88txK2Md8CdV" http://localhost:8080/api/user/companies
        curl -XGET -H "X-API-TOKEN 6y21reV9pj2HCDlJlH21FvgSicwrsLjuBRopifEJY4vmBl6rlyXv88txK2Md8CdV" http://localhost:8080/api/user/companies
        curl -X GET http://localhost:8080/api/user/companies \
                -H "Content-Type: application/json" \
                -H "Accept: application/json" \
                -H "X-API-TOKEN 6y21reV9pj2HCDlJlH21FvgSicwrsLjuBRopifEJY4vmBl6rlyXv88txK2Md8CdV"
```

```bash
         php -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9000 -dxdebug.remote_host=127.0.0.1 -dxdebug.mode=debug -dxdebug.client_port=9000 -dxdebug.client_host=127.0.0.1 -S localhost:8080 -t public/ 
```
