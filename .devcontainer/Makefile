NAME = wp_mvc
DB = $(NAME)_db
NW = $(NAME)_internal

.PHONY: all
all: create

.PHONY: create
create:
	@docker compose build
	@docker volume create $(DB)
	@docker network create $(NW)
	@touch .created

.PHONY: remove
remove: .created
	@docker volume remove $(DB)
	@docker network remove $(NW)
	@rm .created
