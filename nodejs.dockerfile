FROM node:16-alpine as base

WORKDIR /var/www/

#Install Packages
RUN apk --no-cache -U add ca-certificates curl

#Update all packages
RUN apk --no-cache -U upgrade

COPY package.json .

RUN npm install

EXPOSE 3000

FROM base as development
RUN apk --no-cache add bash

