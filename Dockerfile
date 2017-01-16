FROM php:5.6-cli

MAINTAINER Mike Kamornikov <mikekamornikov@gmail.com>

# install main dependencies and configure apt
RUN apt-get update && apt-get install -y zip unzip git --no-install-recommends

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && chmod a+wx /usr/local/bin/composer \
  && chmod a+w /usr/local/bin

# misc
RUN mkdir -p /usr/local/uspec \
  && chmod a+w /usr/local/uspec \
  && curl -sS http://curl.haxx.se/ca/cacert.pem -o /usr/local/uspec/cacert.pem

# configure php
RUN echo "phar.readonly=Off" >> /usr/local/etc/php/conf.d/phar.ini \
  && echo "memory_limit=1G" >> /usr/local/etc/php/conf.d/memory-limit.ini \
  && echo "date.timezone=Europe/Minsk" >> /usr/local/etc/php/conf.d/timezone.ini \
  && echo "openssl.cafile=/usr/local/uspec/cacert.pem" >> /usr/local/etc/php/conf.d/openssl.ini

# install
ADD . /usr/local/uspec
WORKDIR /usr/local/uspec
RUN /usr/local/bin/composer install -q --no-interaction --no-dev

ENTRYPOINT ["/usr/local/uspec/bin/uspec"]
