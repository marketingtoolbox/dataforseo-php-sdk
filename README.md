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

Here's an example of how to use the library with the SERP > Google > Organic endpoint:

```php
<?php
use MarketingToolbox\DataForSEO\Request;
use MarketingToolbox\DataForSEO\Response;

// Let's start by initializing the client
$client = new MarketingToolbox\DataForSEO\Client\Client('your_login', 'your_password');

// Now we can use the client to make requests
// Notice that the request objects' namespaces are similar to the API endpoints

/** @var Response\Serp\Google\Organic\TaskPostResponse $response */
$response = $client->request(new Request\Serp\Google\Organic\TaskPostRequest(
    // In the first request we use the pingback url to get notified when the task is finished.
    // The PingbackUrl value object will create a pingback url including the id and tag query parameters 
    new Request\Serp\Google\Organic\TaskPostRequestData('bikes', 'United States', 'en', 'your_tag', pingbackUrl: (string) new Request\PingbackUrl('https://your-pingback-url.com')),
    new Request\Serp\Google\Organic\TaskPostRequestData('cars', 'United States', 'en'),
));

/** @var Response\Serp\Google\Organic\TaskPostResponseTask $task */
foreach ($response->tasks as $task) {
    // iterate over each task
}

// You can also find a task by the tag you provided when you created it

/** @var Response\Serp\Google\Organic\TaskPostResponseTask|null $task */
$task = $client->findTaskByTag('your_tag');
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
