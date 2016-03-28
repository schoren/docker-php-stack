Docker PHP Stack
----------------

Run a PHP stack in [Docker]. It includes:

- PHP 5.6 FPM
- Nginx
- PostgreSQL
- MariaDB
- Memcached
- Redis

Requirements
============
Install [Docker] and [Compose]

Configuration
=============

Usage
=====

To start the stack, run `docker-compose up -d`.

To see the logs, run `docker-compose logs -f`

To stop the stack, run `docker-compose stop`

Composer
========

To run composer use the following command:

```
docker-compose exec --user 1000 phpfpm composer <command>
```

If you don't like typing, you can use the following alias.

```
alias composer='docker-compose exec --user 1000 phpfpm composer'
```

You should run this command within the project folder or a child.

If you have a local composer installed, the alias will probably override it.

PHP CLI
========

To use PHP CLI use the following command:

```
docker-compose exec --user 1000 phpfpm php
```

If you don't like typing, you can use the following alias.

```
alias php='docker-compose exec --user 1000 phpfpm php'
```

You should run this command within the project folder or a child.

If you have a local php installed, the alias will probably override it.

> NOTE:
>
> The provided UID (1000 in this case) is the *host* UID. It *must* match the UID of the www-data user in the
> guest container. If both UIDs don't match, update the file `docker/php56/Dockerfile`, line 50 and replace the number
> *1000* with your own UID and GUI. You can find those numbers by running `echo $(id -u $USER):$(id -g $USER)`

> NOTE:
>
> These alias will only work within the project directory, and only if the stack is running.



=====================

[Docker]:                      https://www.docker.io/
[Compose]:                     http://docs.docker.com/compose/install/
