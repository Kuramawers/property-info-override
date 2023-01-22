#!/usr/bin/env bash

cp -rT /common /app

composer install

exec "$@"
