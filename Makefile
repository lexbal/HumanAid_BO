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
	php bin/console server:run

.PHONY: fixtures ## Create false data
fixtures:
	php bin/console hautelook:fixtures:load -q

.PHONY: start ## Start project
start:
	composer install
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:migration:migrate

.PHONY: install ## Install dependencies
install:
	composer install

.PHONY: CQtests ## Test the validity of your code
CQtests:
	vendor/bin/phpcs src
	vendor/bin/phpstan analyse --level 6 src

.PHONY: tests-fix ## Fix code
tests-fix:
	vendor/bin/phpcbf src
