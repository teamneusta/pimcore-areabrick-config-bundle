# Use official pimcore php image
# See: https://hub.docker.com/r/pimcore/pimcore
ARG DOCKER_REGISTRY=docker-repository.intern.neusta.de
ARG VERSION=fpm-debug
FROM ${DOCKER_REGISTRY}/pimcore/pimcore:PHP8.1-${VERSION}

RUN mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"

# Set the user id of www-data to the id of the local user, which is passed via
# the docker-compose up command.
# /var/www/ is a home-directory for the www-data user, so we pass the ownership
# for this directory to www-data.
# If there is no user id environment variable set before, set a default
# value here to 1000, so the following commands will not crash.
ARG USER_ID=1000

RUN set -xe \
    && usermod -u $USER_ID www-data \
    && chown www-data: /var/www

USER www-data
