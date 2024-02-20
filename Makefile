#
# general
#
.DEFAULT: init

.PHONY: init
init: vendor #: initialize
	@mkdir -p log
	@chmod 777 log

.PHONY: clean
clean: clean_vendor #: clean project
	@rm -rf ./log/*

.PHONY: default
default: #: default settings to App
	@echo
	@read -p 'Delete "ALL FILES" in ./log ./src/App/Controller/*, ./src/App/Model/*, ./src/App/View/*, and clear ./functions.php ./index.php. [y/N]: ' ANS1; \
	if [ "$$ANS1" = "y" -o "$$ANS1" = "Y" ]; then \
		read -p 'Are you sure? [y/N]: ' ANS2; \
		if [ "$$ANS2" = "y" -o "$$ANS2" = "Y" ]; then \
			rm -rf ./log ./src/App/Controller/* ./src/App/Model/* ./src/App/View/* ./functions.php ./index.php; \
			cp .default/functions.php ./; \
			cp .default/index.php ./; \
			cp .default/_index.php ./src/App/Controller/index.php; \
			cp .default/_index.php ./src/App/Model/index.php; \
			cp .default/_index.php ./src/App/View/index.php; \
			echo done.; \
		fi \
	fi

#
# vendor
#
vendor: composer.json #: install vendor
	@composer install --no-dev

.PHONY: vendor_dev
vendor_dev: vendor/bin/phpunit vendor/bin/phpstan #: install vendor with dev
vendor/bin/phpunit: composer.json
	@composer install
vendor/bin/phpstan: composer.json
	@composer install

.PHONY: reload_vendor
reload_vendor: composer.json #: reload autoloader
	@composer dump-autoload

.PHONY: clean_vendor
clean_vendor: composer.json composer.lock vendor #: clean vendor
	@rm -rf vendor/

.PHONY: unlock_vendor
unlock_vendor: composer.lock #: unlock vendor
	@rm -rf composer.lock

#
# unit test
#

.PHONY: test
test: vendor/bin/phpunit tests/System #: execute System unittest
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --coverage-clover coverage/cov.xml --testsuite 'System'

.PHONY: app_test
app_test: vendor/bin/phpunit tests/App #: execute App unittest
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'App'

.PHONY: clean_test
clean_test: .phpunit.cache coverage coverage.txt #: clean test
	@rm -rf .phpunit.cache coverage coverage.txt

#
# static analysis
#

.PHONY: analyze
analyze: vendor/bin/phpstan #: execute static analysis with PHPStan
	@./vendor/bin/phpstan analyze --memory-limit=4G

.PHONY: baseline
baseline: vendor/bin/phpstan #: generate phpstan-baseline.neon PHPStan
	@./vendor/bin/phpstan analyze --generate-baseline --allow-empty-baseline --memory-limit=4G

#
# help
#

.PHONY: help
help: #: Display this help screen
	@grep -E '^[a-zA-Z_-]+:.*?#: .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?#: "}; {printf "\033[36m%-24s\033[0m %s\n", $$1, $$2}'
