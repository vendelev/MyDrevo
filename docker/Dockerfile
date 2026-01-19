# syntax=docker/dockerfile:1.3-labs

ARG PHP_VERSION="8.5.1-fpm-bookworm"

FROM composer:2.9.2 AS composer
FROM mlocati/php-extension-installer:2.9.24 AS php-extension-installer

FROM php:${PHP_VERSION}

ARG LOCALTIME="Europe/Moscow"
ARG XDEBUG="3.5.0"

COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN <<EOF
  set -e
  apt-get update
  apt-get install -y zip unzip tzdata sudo wget curl
  rm /etc/localtime
  ln -s /usr/share/zoneinfo/${LOCALTIME} /etc/localtime
  echo ${LOCALTIME} > /etc/timezone
  echo 'date.timezone = ${LOCALTIME}' >> $PHP_INI_DIR/php.ini
  install-php-extensions sockets zip intl pcntl curl opcache xdebug-${XDEBUG} bcmath
  apt-get remove -q -y ${PHPIZE_DEPS} ${BUILD_DEPENDS}
  apt-get clean autoclean
  apt-get autoremove --yes
  rm -rf /var/lib/{apt,dpkg,cache,log,lists}/*
  rm -rf /var/cache/apt/archives /tmp/* /var/tmp/*
EOF

COPY --from=composer /usr/bin/composer /usr/bin/

# Отключение генерации .htaccess для composer в домашней папке.
ENV COMPOSER_HTACCESS_PROTECT=0

ARG UID=1000
ARG GID=1000
ENV UID=${UID}
ENV GID=${GID}

ARG XDEBUG_MODE=coverage,debug
ENV XDEBUG_MODE=$XDEBUG_MODE

RUN <<EOF
  set -e
  groupmod --gid=${GID} www-data
  usermod --uid=${UID} --gid=${GID} www-data
  usermod -aG sudo www-data && echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
  mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"
EOF

USER www-data

WORKDIR /var/www/backend
