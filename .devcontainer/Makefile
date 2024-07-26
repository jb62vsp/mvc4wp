NAME = mvc4wp
DB = $(NAME)_db
NW = $(NAME)_internal

.PHONY: all
all: create

.PHONY: create
create:
	@cp _env .env
	@docker compose build
	@docker volume create $(DB)
	@docker network create $(NW)
	@touch .created

.PHONY: clean
clean: .created
	@docker volume remove $(DB); \
	 docker network remove $(NW)
	@rm -f .env
	@rm -f .created
