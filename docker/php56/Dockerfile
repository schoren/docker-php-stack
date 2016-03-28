FROM ubuntu:14.04

RUN apt-get update && apt-get install -y \
        curl \
        python-software-properties \
        software-properties-common \
    && LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php5-5.6 \
    && apt-get update \
    && apt-get install -y \
        php5-fpm \
        php5-pgsql \
        php5-mysql \
        php5-memcached \
        php5-redis \
        php5-mcrypt \
        php5-curl \
        php5-intl \
    && apt-get remove --purge -y \
        python-software-properties \
        software-properties-common \
    && apt-get autoremove -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN set -ex \
    && cd /etc/php5/fpm \
    && { \
        echo '[global]'; \
        echo 'error_log = /proc/self/fd/2'; \
        echo; \
        echo '[www]'; \
        echo '; if we send this to /proc/self/fd/1, it never appears'; \
        echo 'access.log = /proc/self/fd/2'; \
        echo; \
        echo 'clear_env = no'; \
        echo; \
        echo '; Ensure worker stdout and stderr are sent to the main error log.'; \
        echo 'catch_workers_output = yes'; \
    } | tee pool.d/docker.conf \
    && { \
        echo '[global]'; \
        echo 'daemonize = no'; \
        echo; \
        echo '[www]'; \
        echo 'listen = [::]:9000'; \
    } | tee pool.d/zz-docker.conf

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN mkdir /var/www/.composer /var/www/.ssh \
    && chown -R www-data:www-data /var/www/.composer /var/www/.ssh

EXPOSE 9000

CMD ["php5-fpm", "-F"]
