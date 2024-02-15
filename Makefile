#
# general
#
.DEFAULT: init

.PHONY: init
init: vendor

.PHONY: clean
clean: vendor_clear test_clear
	@rm -rf 

.PHONY: default
default: init
	@rm -rf ./src/App/Controllers/* ./src/App/Models/* ./src/App/Models/* ./src/App/Views/* ./src/bootstrap.php ./functions.php ./index.php
	@cp .init/bootstrap.php ./src/App/
	@cp .init/functions.php ./
	@cp .init/index.php ./

#
# vendor
#
.PHONY: vendor
vendor: composer.json
	@composer install --no-dev
	@composer dump-autoload

.PHONY: vendor_dev
vendor_dev: composer.json
	@composer install

.PHONY: vendor_clear
vendor_clear: composer.json composer.lock vendor/
	@rm -rf vendor/

.PHONY: vendor_unlock
vendor_unlock: composer.lock
	@rm -rf composer.lock

#
# unit test
#

.PHONY: test
test: vendor/bin/phpunit tests/System
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'system'

.PHONY: test_app
test_app: vendor/bin/phpunit tests/App
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'app'

.PHONY: test_clear
test_clear:
	@rm -rf .phpunit.cache coverage