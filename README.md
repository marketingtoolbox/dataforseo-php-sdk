# PHP library for the DataForSEO API

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

## Installation

```bash
composer require marketingtoolbox/dataforseo-php-sdk
```

## Usage

```php
<?php
// Let's start by initializing the client
$client = new \MarketingToolbox\DataForSEO\Client\Client('your_login', 'your_password');

// Now we can use the client to make requests
```

[ico-version]: https://poser.pugx.org/marketingtoolbox/dataforseo-php-sdk/v/stable
[ico-license]: https://poser.pugx.org/marketingtoolbox/dataforseo-php-sdk/license
[ico-github-actions]: https://github.com/marketingtoolbox/dataforseo-php-sdk/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/marketingtoolbox/dataforseo-php-sdk/branch/master/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fmarketingtoolbox%2Fdataforseo-php-sdk%2Fmaster

[link-packagist]: https://packagist.org/packages/marketingtoolbox/dataforseo-php-sdk
[link-github-actions]: https://github.com/marketingtoolbox/dataforseo-php-sdk/actions
[link-code-coverage]: https://codecov.io/gh/marketingtoolbox/dataforseo-php-sdk
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/marketingtoolbox/dataforseo-php-sdk/master
