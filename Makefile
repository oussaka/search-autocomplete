.SILENT:
.PHONY: build test help server install
.DEFAULT_GOAL= help

PORT?=8080

## Colors
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m
COLOR_ERROR   = \033[0;31m
COLOR_COM     = \033[0;34m
COLOR_OBJ     = \033[0;36m


## Help
help:
	printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	printf " make [target]\n\n"
	printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

###########
# Install #
###########

composer.lock: composer.json
	composer update

vendor: composer.lock
	composer install --verbose
	bin/console doctrine:database:create --if-not-exists

## Install application
install: vendor

install@test: export SYMFONY_ENV = test
install@test:
	# Composer
	composer install --verbose --no-progress --no-interaction
	# Doctrine
	bin/console doctrine:database:drop --force --if-exists
	bin/console doctrine:database:create --if-not-exists
	bin/console doctrine:schema:update --force

install@demo: export SYMFONY_ENV = prod
install@demo:
	# Composer
	composer install --verbose --no-progress --no-interaction --prefer-dist --optimize-autoloader
	# Symfony cache
	bin/console cache:warmup --no-debug
	# Doctrine migrations
	bin/console doctrine:migrations:migrate --no-debug --no-interaction

install@prod: export SYMFONY_ENV = prod
install@prod:
	# Composer
	composer install --verbose --no-progress --no-interaction --prefer-dist --optimize-autoloader --no-dev
	# Symfony cache
	bin/console cache:warmup --no-debug
	# Doctrine migrations
	bin/console doctrine:migrations:migrate --no-debug --no-interaction

##########
# Build #
##########

build:
	if [ -f "gulpfile" ]; then gulp --dev; fi;
build@demo:
	if [ -f "gulpfile" ]; then gulp; fi;
build@prod:
	if [ -f "gulpfile" ]; then gulp; fi;

##########
# Custom #
##########

cc:
	php bin/console cache:clear --no-warmup
	php bin/console cache:warmup

cc@prod: export SYMFONY_ENV = prod
cc@prod:
	php bin/console cache:clear --no-warmup
	php bin/console cache:warmup

## Lance les tests unitaire
test: install
	php ./vendor/bin/phpunit --stop-on-failure

## Nettoie le cache
cache-clear:
	rm -rf ./tmp

## Lance le serveur interne de PHP
server: install
	ENV=dev php -ddisplay_errors=1 bin/console server:start 0.0.0.0:$(PORT)

## Stoppe le serveur interne de PHP
server@stop:
	php bin/console server:stop