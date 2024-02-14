#
# unit test
#

.PHONY: test
test: vendor/bin/phpunit tests/
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=coverage.txt --coverage-html=coverage
