# Rest Api Symfony Application
========================

Requirements
------------

  * PHP 7.1.3 or higher;
  * PDO-mysql PHP extension enabled;
  * and the [usual Symfony application requirements][1].

Installation
------------

Execute this command to install the project:

```bash
git clone https://github.com/duvaldavid60/api_test
cd api_test
composer install
```
Database create and migration
-----------------------------
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
JWT installation
-----------------------------
The passphrase is in .env file
```bash
mkdir -p config/jwt 
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

Usage
-----

Just execute this command to run the built-in web server and access the application in your
browser at <http://localhost:8000>:

```bash
php bin/console server:run
```

Alternatively, you can [configure a fully-featured web server][2] like Nginx
or Apache to run the application.
