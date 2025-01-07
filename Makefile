SHELL := /bin/bash

start:
	ddev start
stop:
	ddev stop
restart:
	ddev restart
desc:
	ddev describe
xde:
	ddev exec enable_xdebug
xdd:
	ddev exec disable_xdebug
cache:
	ddev artisan optimize:clear
codecheck:
	docker run --rm --workdir=/app --volume "${PWD}":/app oskarstark/php-cs-fixer-ga:3.16.0 --diff --dry-run
codefix:
	docker run --rm --workdir=/app --volume "${PWD}":/app oskarstark/php-cs-fixer-ga:3.16.0
test:
	ddev exec -d /var/www/html vendor/bin/phpunit
coverage:
	ddev exec enable_xdebug
	ddev exec -d /var/www/html XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html ./tests/coverage
	ddev exec disable_xdebug