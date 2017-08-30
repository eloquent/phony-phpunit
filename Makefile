.PHONY: test
test: install
	php --version
	vendor/bin/phpunit --no-coverage

.PHONY: test-hhvm
test-hhvm: install
	test/bin/hhvm-3.21 sh -c "php --version; PHP_ERROR_EXCEPTION_DEPRECATIONS=1 php -d 'hhvm.php7.all=1' vendor/bin/phpunit --no-coverage"

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
lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix --using-cache no

.PHONY: install
install:
	composer install

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
