install:
	docker-compose run --rm -u $(shell id -u) php_sandbox composer install

test: test-symfony4-functional test-symfony5-functional test-symfony6-functional

test-symfony4-functional:
	docker-compose run --rm -u $(shell id -u) symfony4_sandbox composer test:functional:coverage

test-symfony5-functional:
	docker-compose run --rm -u $(shell id -u) symfony5_sandbox composer test:functional:coverage

test-symfony6-functional:
	docker-compose run --rm -u $(shell id -u) symfony6_sandbox composer test:functional:coverage

connect:
	docker-compose run --rm -u $(shell id -u) php_sandbox bash

connect-symfony4:
	docker-compose run --rm -u $(shell id -u) symfony4_sandbox bash

connect-symfony5:
	docker-compose run --rm -u $(shell id -u) symfony5_sandbox bash

connect-symfony6:
	docker-compose run --rm -u $(shell id -u) symfony6_sandbox bash

clean-ignored:
	git clean -dfX
