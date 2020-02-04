.PHONY: start
start: erase build up db ## Clean environment, recreate dependencies and start.

.PHONY: stop
stop: ## stop environment
		docker-compose stop

.PHONY: rebuild
rebuild: start ## same as start

.PHONY: erase
erase: ## stop and delete containers, clean volumes.
		docker-compose stop
		docker-compose rm -v -f

.PHONY: fixtures
fixtures: ## Creates development fixtures. Aka demo data.
		docker-compose run --rm php sh -lc 'bin/console doctrine:fixtures:load --append'

.PHONY: build
build: ## Build environment and run composer install.
		docker-compose build
		docker-compose run --rm php sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer install'

.PHONY: artifact
artifact: ## Build production artifact
		docker-compose -f docker-compose.prod.yml build

.PHONY: composer-update
composer-update: ## Update project dependencies
		docker-compose run --rm php sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer update'

.PHONY: up
up: ## Spin up environment
		docker-compose up -d

.PHONY: phpunit
phpunit: db ## Execute project unit tests
		docker-compose exec php sh -lc "./vendor/bin/phpunit $(conf)"

.PHONY: cs
cs: ## Executes php cs fixer
		docker-compose run --rm php sh -lc './vendor/bin/php-cs-fixer --no-interaction -vvvv fix'

.PHONY: api-export
api-export: ## Exports api schema as api.json
		docker-compose run --rm php sh -lc './bin/console api:openapi:export -o api.json'

.PHONY: api-export
gql-export: ## Exports GraphQL api schema as gql.json
		docker-compose run --rm php sh -lc './bin/console api:graphql:export -o schema.graphql'

.PHONY: cs-check
cs-check: ## Executes php cs fixer in dry run mode
		docker-compose run --rm php sh -lc './vendor/bin/php-cs-fixer --no-interaction --dry-run --diff -v fix'

.PHONY: layer
layer: ## Check issues with layers
		docker-compose run --rm php sh -lc 'php bin/deptrac.phar analyze --formatter-graphviz=0'

.PHONY: db
db: ## Recreate database
		docker-compose exec php sh -lc './bin/console d:d:d --force'
		docker-compose exec php sh -lc './bin/console d:d:c'
		docker-compose exec php sh -lc './bin/console d:m:m -n'

.PHONY: schema-validate
schema-validate: ## Validate database schema
		docker-compose exec php sh -lc './bin/console d:s:v'

.PHONY: redis-clear
redis-clear: ## Clear Redis Cache from DB 0
		docker-compose exec php sh -lc 'redis-cli -h redis -n 0 flushdb'

.PHONY: api
api: redis-clear ## Re-Generate Javascript API-Client
		docker-compose exec php sh -lc 'bin/console api:openapi:export -o api.json && yarn install'
		docker-compose exec php sh -lc 'export TS_POST_PROCESS_FILE="/usr/local/bin/prettier --write" \
		    && yarn openapi-generator generate -i api.json -g typescript-axios -o api --enable-post-process-file \
		    --additional-properties supportsES6=true --skip-validate-spec'
		docker-compose exec php sh -lc 'rm -rf api.json node_modules'

.PHONY: sh
sh: ## Open shell terminal inside container. Example: make s=php sh
		docker-compose exec $(s) sh -l

.PHONY: fish
fish: ## Open fish terminal inside php container.
		docker-compose exec php fish -l

.PHONY: logs
logs: ## Look for 's' service logs, make s=php logs
		docker-compose logs -f $(s)

.PHONY: wait-for-elastic
wait-for-elastic: ## Health check for elastic
		docker-compose run --rm php sh -lc 'sh ./etc/ci/wait-for-elastic.sh elasticsearch:9200'

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
