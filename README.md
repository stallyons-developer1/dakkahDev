# Dakkah Dev

## Installation
Install the dependencies and devDependencies.
```sh
npm install 
```
if  got npm error then try this
```sh
npm install -g npm@6.14.8
```
After that
```sh
composer install
```
create env file and setup database credentials and then run
```sh
php artisan key:generate
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

## License

MIT


