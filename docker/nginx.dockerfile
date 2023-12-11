FROM nginx:1.23-alpine as base

ARG DOCKER_DIR=.
ARG SOURCE_DIR=..

#Update all packages
RUN apk --no-cache -U upgrade

# Setup Logs
RUN mkdir /etc/nginx/logs
RUN touch /etc/nginx/logs/static.log

# Setup Tempory Folder Locations
RUN mkdir /tmp/nginx

# Copy All Sites
ADD $DOCKER_DIR/nginx/conf.d/* /etc/nginx/conf.d/

# Set Default Working Directory
WORKDIR /var/www/

# Set up Port 80 and 443(SSL)
EXPOSE 80 443

FROM base as development

RUN apk --no-cache -U add bash

