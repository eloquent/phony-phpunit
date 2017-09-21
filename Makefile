.PHONY: test
test: install
	php --version
	vendor/bin/phpunit --no-coverage

.PHONY: coverage
coverage: install
	phpdbg --version
	phpdbg -qrr vendor/bin/phpunit

.PHONY: open-coverage
open-coverage:
	open coverage/index.html

.PHONY: integration
integration: install
	test/integration/run

.PHONY: lint
lint: install
	vendor/bin/php-cs-fixer fix

.PHONY: install
install:
	composer install
