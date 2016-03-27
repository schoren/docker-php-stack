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
docker run --rm -v $(pwd):/app composer/composer <command>
```

You can create a file in `/usr/local/bin/composer` with this:

```
#!/bin/sh
export PATH=/sbin:/bin:/usr/sbin:/usr/bin:/usr/local/sbin:/usr/local/bin
docker run --rm -v $(pwd):/app -v ~/.ssh:/root/.ssh composer/composer $@
```

And make it executable:

```
sudo chmod +x /usr/local/bin/composer
```

Then you can run `composer` command as usual.

=====================

[Docker]:                      https://www.docker.io/
[Compose]:                     http://docs.docker.com/compose/install/
