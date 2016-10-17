# Diepreords





## Server Requirements
* laravel and it's needed dependencies
* composer

## Installation
1. Clone this project into a folder
2. Rename .env.example to .env and modify it (check the laravel documentation)
3. Edit the `database/seeds/UsersTableSeeder.php` file for a proper first user
4. Go to the folder and do `composer install` and then `php artisan migrate:refresh --seed`
5. Point your webserver to the public subfolder


