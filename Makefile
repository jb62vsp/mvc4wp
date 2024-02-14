#
# unit test
#

.PHONY: test
test: vendor/bin/phpunit tests/
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --colors --coverage-text=public/coverage.txt --coverage-html=public/coverage
