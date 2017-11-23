Symfony Demo Application
========================

[![Build Status](https://travis-ci.org/Codeception/symfony-demo.svg?branch=2.1)](https://travis-ci.org/Codeception/symfony-demo)

We use official "Symfony Demo Application" to demonstrate basics of Codeception testing.

![demopic](app/data/demo.png)

There are **acceptance**, **functional**, and **unit** tests included.
Acceptance tests are located in the `tests/acceptance` directory in the root of a project,
while `functional`/`unit` tests are included in `src/AppBundle/test`.

Codeception executes acceptance tests globally and all tests included in bundles.

## Run Codeception Tests

```
composer install -n
php app/console doctrine:schema:update --force --env test
php app/console doctrine:fixtures:load -n --env test
php app/console server:start
php bin/codecept run
```

### Unit and Functional Tests

Unit and Functional tests are supposed to be located in corresponding Bundle. A simple Codeception configuration was created `src/AppBundle`.
Codeception is configured (in `src/AppBundle/codeception.yml`) to use `app` directory for handling logs and data.

Tests are loaded from `src/AppBundle/test` (we didn't use `Tests` folder to separate symfony-demo original tests and tests of Codeception).
Unit tests can be executed from `src/AppBundle` dir:

```
php bin/codecept run -c src/AppBundle
```

## Acceptance Tests

Acceptance tests require web server to be started. They interact with application as regular user would do.
Ideally, this should include browser testing, however we use browser emulator PhpBrowser to do some basic testing.

```
php bin/codecept run acceptance
```

-------

## Below goes official README of Symfony Demo Application:

---

The "Symfony Demo Application" is a reference application created to show how
to develop Symfony applications following the recommended best practices.

Requirements
------------

  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][1].

Installation
------------

Execute this command to install the project:

```bash
$ composer create-project symfony/symfony-demo
```

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

Usage
-----

There's no need to configure anything to run the application. Just execute this
command to run the built-in web server and access the application in your
browser at <http://localhost:8000>:

```bash
$ cd symfony-demo/
$ php bin/console server:run
```

Alternatively, you can [configure a fully-featured web server][2] like Nginx
or Apache to run the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd symfony-demo/
$ ./vendor/bin/simple-phpunit
```

[1]: https://symfony.com/doc/current/reference/requirements.html
[2]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
