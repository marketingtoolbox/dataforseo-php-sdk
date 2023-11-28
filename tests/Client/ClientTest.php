<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use MarketingToolbox\DataForSEO\Request\Serp\Google\Organic\TaskPostRequest;
use MarketingToolbox\DataForSEO\Request\Serp\Google\Organic\TaskPostRequestData;
use MarketingToolbox\DataForSEO\Response\Serp\Google\Organic\TaskPostResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @covers \MarketingToolbox\DataForSEO\Client\Client
 */
final class ClientTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_works(): void
    {
        $httpResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200, 'OK')->withBody(
            Psr17FactoryDiscovery::findStreamFactory()->createStream(self::getValidJson()),
        );

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->sendRequest(Argument::type(RequestInterface::class))->willReturn($httpResponse);

        $client = new Client('login', 'password');
        $client->setHttpClient($httpClient->reveal());
        $response = $client->request(new TaskPostRequest(
            new TaskPostRequestData('herretøj', 'Denmark', 'da', 'tag'),
            new TaskPostRequestData('bukser', 'Denmark', 'da'),
        ));

        self::assertInstanceOf(TaskPostResponse::class, $response);
        self::assertCount(2, $response->tasks);
        self::assertSame(20000, $response->statusCode);
        self::assertSame('Ok.', $response->statusMessage);
        self::assertSame(2, $response->tasksCount);
        self::assertSame(0, $response->tasksError);

        $task = $response->findTaskByTag('tag');
        self::assertNotNull($task);
    }

    private static function getValidJson(): string
    {
        return <<<JSON
{
    "version": "0.1.20231117",
    "status_code": 20000,
    "status_message": "Ok.",
    "time": "0.0560 sec.",
    "cost": 0.0012,
    "tasks_count": 2,
    "tasks_error": 0,
    "tasks": [
        {
            "id": "11281117-6273-0066-0000-f8286a48531b",
            "status_code": 20100,
            "status_message": "Task Created.",
            "time": "0.0051 sec.",
            "cost": 0.0006,
            "result_count": 0,
            "path": [
                "v3",
                "serp",
                "google",
                "organic",
                "task_post"
            ],
            "data": {
                "api": "serp",
                "function": "task_post",
                "se": "google",
                "se_type": "organic",
                "keyword": "herretøj",
                "location_name": "Denmark",
                "language_code": "da",
                "tag": "tag",
                "device": "desktop",
                "os": "windows"
            },
            "result": null
        },
        {
            "id": "11281117-6273-0066-0000-05bb214eb8c1",
            "status_code": 20100,
            "status_message": "Task Created.",
            "time": "0.0043 sec.",
            "cost": 0.0006,
            "result_count": 0,
            "path": [
                "v3",
                "serp",
                "google",
                "organic",
                "task_post"
            ],
            "data": {
                "api": "serp",
                "function": "task_post",
                "se": "google",
                "se_type": "organic",
                "keyword": "bukser",
                "location_name": "Denmark",
                "language_code": "da",
                "device": "desktop",
                "os": "windows"
            },
            "result": null
        }
    ]
}
JSON;
    }
}
