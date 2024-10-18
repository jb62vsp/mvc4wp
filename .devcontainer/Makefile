NAME = mvc4wp
WP = $(NAME)_wordpress
DB = $(NAME)_db
NW = $(NAME)_internal

.DEFAULT_GOAL := help

#
# create
#

.PHONY: create
create: #: create resources
	@cp _env .env
	@docker compose build
	@docker volume create $(WP)
	@docker volume create $(DB)
	@docker network create $(NW)
	@touch .created

#
# cli
#

.PHONY: cli
cli: .env .created #: login wp-cli shell
	@docker compose -p mvc4wp_devcontainer run --rm -w /var/www/html/wordpress cli bash

#
# clean
#

.PHONY: clean
clean: .created #: clean resources
	@docker volume remove $(WP); \
	 docker volume remove $(DB); \
	 docker network remove $(NW)
	@rm -f .env
	@rm -f .created

#
# build
#

.PHONY: build
build: #: force build
	@docker compose build --no-cache

#
# help
#

.PHONY: help
help: #: Display this help screen
	@grep -E '^[a-zA-Z_-]+:.*?#: .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?#: "}; {printf "\033[36m%-24s\033[0m %s\n", $$1, $$2}'
