#!/usr/bin/env bash
php bin/console cache:clear && php bin/console asset:install && php bin/console assetic:dump && php bin/console server:run