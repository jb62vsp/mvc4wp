#
# general
#
.DEFAULT: init

.PHONY: init
init: vendor #: initialize

.PHONY: clean
clean: clean_vendor clean_test #: clean project

.PHONY: default
default: init #: default settings to App
	@rm -rf ./src/App/Controllers/* ./src/App/Models/* ./src/App/Models/* ./src/App/Views/* ./src/bootstrap.php ./functions.php ./index.php
	@cp .init/bootstrap.php ./src/App/
	@cp .init/functions.php ./
	@cp .init/index.php ./

#
# vendor
#
.PHONY: vendor
vendor: composer.json #: install vendor
	@composer install --no-dev

.PHONY: vendor_dev
vendor_dev: composer.json #: install vendor with dev
	@composer install

.PHONY: reload_vendor
reload_vendor: composer.json #: reload autoloader
	@composer dump-autoload

.PHONY: clean_vendor
clean_vendor: composer.json composer.lock vendor/ #: clean vendor
	@rm -rf vendor/

.PHONY: unlock_vendor
unlock_vendor: composer.lock #: unlock vendor
	@rm -rf composer.lock

#
# unit test
#

.PHONY: test
test: system_test #: execute unittest

.PHONY: system_test
system_test: vendor/bin/phpunit tests/System #: execute System unittest
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'system'

.PHONY: app_test
app_test: vendor/bin/phpunit tests/App #: execute App unittest
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'app'

.PHONY: clean_test
clean_test: #: clean test
	@rm -rf .phpunit.cache coverage

#
# help
#

.PHONY: help
help: #: Display this help screen
	@grep -E '^[a-zA-Z_-]+:.*?#: .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?#: "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
