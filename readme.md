# Dieprecords
This was a quick & dirty attempt to build a website to handle highscores for http://diep.io.


## Demosite (for now)
[Demo](https://dieprecords.moepl.eu/)

## Server Requirements
* laravel and its needed dependencies
* composer
* nodejs
* gulp

## Installation
1. Clone this project into a folder
2. Rename .env.example to .env and modify it (check the laravel documentation). Make sure to put the imgur settings in to be able to handle non direct links from imgur.
3. Edit the `database/seeds/UsersTableSeeder.php` file for a proper first user
4. Go to the folder and execute 
```
composer install
npm install
php artisan migrate:refresh --seed
gulp --production
```

5. Point your webserver to the public subfolder
