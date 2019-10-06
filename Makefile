.PHONY: bench coverage cs help infection it test

it: cs test bench ## Runs the cs, test, and bench targets

bench: vendor
	vendor/bin/phpbench run --report=aggregate

coverage: vendor ## Collects coverage from running unit tests with phpunit
	mkdir -p .build/phpunit
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml --dump-xdebug-filter=.build/phpunit/xdebug-filter.php
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml --coverage-text --prepend=.build/phpunit/xdebug-filter.php

cs: vendor ## Fixes code style issues with php-cs-fixer
	mkdir -p .build/php-cs-fixer
	vendor/bin/php-cs-fixer fix --config=.php_cs --diff --diff-format=udiff --verbose

help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

infection: vendor ## Runs mutation tests with infection
	mkdir -p .build/infection
	vendor/bin/infection --ignore-msi-with-no-mutations --min-covered-msi=80 --min-msi=80

test: vendor ## Runs auto-review and unit tests with phpunit
	mkdir -p .build/phpunit
	vendor/bin/phpunit --configuration=test/AutoReview/phpunit.xml
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml

vendor: composer.json composer.lock
	composer validate --strict
	composer install --no-interaction --no-progress --no-suggest
