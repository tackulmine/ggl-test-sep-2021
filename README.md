<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to Run

First, please install xampp.

For test 1-3, please open a console and type the commands below:

- First Test: `php artisan first:test`
- Second Test: `php artisan second:test`
- Third Test: `php artisan third:test`

For test 4-5, open a console at this project and follow the instructions below:

- type `cp .env.example .env`
- type `php artisan key:generate`
- open .env in root project and please adjust the database connection
- type `php artisan migrate:fresh --seed`
- type `php artisan serve`
- open a browser and type the address `localhost:8000`
- please login with username: `admin@admin.com` and password: `password`
