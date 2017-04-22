#!/bin/sh

date >> /var/www/html/GuessIt/log/cron_log
php -f /var/www/html/GuessIt/tablaestatica_def.php
