


## GET CODE:

 
 $ composer install



## Installation avec Docker

$ docker-compose build
$ docker-compose up
$ docker exec -it  api_php  bash


## Installation sans Docker

            ## Les Requirements:

             - PHP version: 7.1.3 or higher

             - Mysql DB

             - POSTMAN

             - composer

             - GIT


## CREATE DATABASE:

 $ php bin/console doctrine:database:create

## CREATE TABLES:

 $ php bin/console do:sch:update -f

## INSERT DATA TEST

 $ php bin/console doctrine:fixtures:load --append


##  Generate the SSH keys :

 $ mkdir -p config/jwt  

 $ openssl genrsa -out config/jwt/private.pem -aes256 4096

 $ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem