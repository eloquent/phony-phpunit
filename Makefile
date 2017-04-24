test: install
	php --version
	vendor/bin/phpunit --no-coverage

coverage: install
	phpdbg --version
	phpdbg -qrr vendor/bin/phpunit

open-coverage:
	open coverage/index.html

integration: install
	test/integration/run

lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix --using-cache no

install:
	composer install

.PHONY: test coverage open-coverage integration lint install

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
