.PHONY install

composer:
	composer install

bd:
	php bin/console db

npm: 
	npm install

gulp: 
	npm install -g gulp-cli

gulp:
	gulp build

install: composer bd npm gulp gulp2

