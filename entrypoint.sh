#!/bin/bash

composer install --no-interaction
composer dump-autoload

# Clear and warm up cache
bin/console cache:clear

symfony server:start
