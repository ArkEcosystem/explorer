# Template - Laravel

<p align="center">
    <img src="https://github.com/ArkEcosystem/template-laravel/blob/master/banner.png?raw=true" />
</p>

[![Build Status](https://badgen.now.sh/circleci/github/ARKEcosystem/template-laravel)](https://circleci.com/gh/ARKEcosystem/template-laravel)
[![Codecov](https://badgen.now.sh/codecov/c/github/arkecosystem/template-laravel)](https://codecov.io/gh/arkecosystem/template-laravel)
[![License: MIT](https://badgen.now.sh/badge/license/MIT/green)](https://opensource.org/licenses/MIT)

> Lead Maintainer: [John Doe](https://github.com/username)

## Installation

### Requirements

-   [Composer](https://getcomposer.org)
-   [Valet](https://laravel.com/docs/8.x/valet) or [Homestead](https://laravel.com/docs/8.x/homestead)

### Development

Currently the instructions are for Valet

```bash
git clone https://github.com/ArkEcosystem/explorer.ark.io.git
cd explorer.ark.io
composer install
yarn install

cp .env.example .env
php artisan key:generate
php artisan migrate:fresh
php artisan migrate --path=tests/migrations --database=explorer
composer play
php artisan storage:link
yarn run watch

valet link explorer-ark-io
```

*Protip:* You will need access to a Core Postgres database. The details can be specified in the `.env` file under `EXPLORER_DB_*`.

Afterwards, you can navigate to `explorer-ark-io.test` in your browser to see it in action

## Security

If you discover a security vulnerability within this package, please send an e-mail to security@ark.io. All security vulnerabilities will be promptly addressed.

## Credits

This project exists thanks to all the people who [contribute](../../contributors).

## License

[MIT](LICENSE) © [ARK Ecosystem](https://ark.io)
