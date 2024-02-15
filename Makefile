#
# unit test
#

.PHONY: test
test: vendor/bin/phpunit tests/System
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'system'

test_app: vendor/bin/phpunit tests/App
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage --testsuite 'app'