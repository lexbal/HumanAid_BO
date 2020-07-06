CONSOLE=bin/console
DC=docker-compose
HAS_DOCKER:=$(shell command -v $(DC) 2> /dev/null)

ifdef HAS_DOCKER
	ifdef PHP_ENV
		EXECROOT=$(DC) exec -e PHP_ENV=$(PHP_ENV) app
		EXEC=$(DC) exec -e PHP_ENV=$(PHP_ENV) app
	else
		EXECROOT=$(DC) exec app
		EXEC=$(DC) exec app
	endif
else
	EXECROOT=
	EXEC=
endif

.DEFAULT_GOAL := help

.PHONY: help ## Generate list of targets with descriptions
help:
		@grep '##' Makefile \
		| grep -v 'grep\|sed' \
		| sed 's/^\.PHONY: \(.*\) ##[\s|\S]*\(.*\)/\1:\t\2/' \
		| sed 's/\(^##\)//' \
		| sed 's/\(##\)/\t/' \
		| expand -t14

.PHONY: startServer ## Start symfony server
startServer:
	$(EXEC) $(CONSOLE) server:run

.PHONY: fixtures ## Create false data
fixtures:
	$(EXEC) $(CONSOLE) hautelook:fixtures:load -q

.PHONY: start ## Start project
start:
	composer install
	$(EXEC) $(CONSOLE) doctrine:database:create --if-not-exists
	$(EXEC) $(CONSOLE) doctrine:schema:update --force

.PHONY: install ## Install dependencies
install:
	composer install

.PHONY: CQtests ## Test the validity of your code
CQtests:
	vendor/bin/phpcs --standard=PSR2 --ignore=src/Kernel.php src
	vendor/bin/phpstan analyse --level 6 src

.PHONY: UNITtests ## Test unit
UNITtests:
	php bin/phpunit tests

.PHONY: tests-fix ## Fix code
tests-fix:
	vendor/bin/phpcbf src
