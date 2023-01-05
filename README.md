# File storage API

## Local environment

If you need to run project, you must have Docker on your PC.

Following command starts project:
```shell
    ./deployment/local/scripts/start.sh
```

Following command connects to container with PHP-FPM:
```shell
    ./deployment/local/scripts/php_fpm_bash.sh
```

## Links

API: http://127.0.0.1:31080/api <br/>
Documentation: http://127.0.0.1:31080/docs <br/>
PhpMyAdmin: http://127.0.0.1:8090

## Console commands

Before running of console commands you need to connect to PHP-FPM container. <br/>
Creation of role:
```shell
    php artisan admin:create-role
```
Creation of user:
```shell
    php artisan admin:create-user
```
Removing of expired temporary links:
```shell
    php artisan link:clear-expired-temporary
```
