<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Running application:

- ```cp .env.example .env```
- ```docker compose up -d```
- ```docker compose exec app composer install```
- ```docker compose exec app php artisan key:generate```
- ```docker compose exec app npm install && npm run build```
- ```docker compose exec app php artisan test```
- ```docker compose exec app php artisan migrate:fresh --seed```

## URL:
- ```http://localhost/login```

## Users:
- Admin: `email` - `admin@example.com`, `password` - `password`
- Employee: `email` - `employee@example.com`, `password` - `password`
