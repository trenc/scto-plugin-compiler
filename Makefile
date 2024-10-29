.PHONY: all distclean help lint lint-fix test vendor

PWD := $(shell pwd)
UID := $(shell id -u)
GID := $(shell id -g)
PLUGIN_NAME := $(notdir $(CURDIR))
PHP	:= sudo docker run --rm -it -v $(PWD):/$(PLUGIN_NAME) -w /$(PLUGIN_NAME) --user $(UID):$(GID) composer

all: test

try:
	@$(PHP) php ./bin/cli.php compile ./src manifest.json

distclean:
	@rm -rf vendor composer.lock

lint:
	@$(PHP) ./vendor/bin/pint --test -v

lint-fix:
	@$(PHP) ./vendor/bin/pint

test:
	@$(PHP) ./vendor/bin/phpunit --testdox

vendor: distclean
	@$(PHP) composer install

help:
	@echo "Manage project"
	@echo ""
	@echo "Usage:"
	@echo "  $$ make [command]"
	@echo ""
	@echo "Commands:"
	@echo ""
	@echo "  $$ make lint"
	@echo "  Lint code style"
	@echo ""
	@echo "  $$ make lint-fix"
	@echo "  Lint and fix code style"
	@echo ""
	@echo "  $$ make distclean"
	@echo "  Delete installed dependencies"
	@echo ""
	@echo "  $$ make test"
	@echo "  Run tests"
	@echo ""
	@echo "  $$ make vendor"
	@echo "  Install dependencies"
	@echo ""
