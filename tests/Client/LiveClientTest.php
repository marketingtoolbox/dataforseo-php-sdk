<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Client;

use MarketingToolbox\DataForSEO\Request\Serp\Google\Organic\TaskPostRequest;
use MarketingToolbox\DataForSEO\Request\Serp\Google\Organic\TaskPostRequestData;
use MarketingToolbox\DataForSEO\Response\Serp\Google\Organic\TaskPostResponse;
use PHPUnit\Framework\TestCase;

final class LiveClientTest extends TestCase
{
    private string $login;

    private string $password;

    /**
     * @test
     */
    public function it_posts_task_on_serp_google_organic_endpoint(): void
    {
        $client = new Client($this->login, $this->password);
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

    protected function setUp(): void
    {
        $live = (bool) getenv('LIVE');

        if ($live) {
            $this->login = (string) getenv('DATAFORSEO_LOGIN');
            $this->password = (string) getenv('DATAFORSEO_PASSWORD');
        } else {
            $this->markTestSkipped('This test is only run in live mode');
        }
    }
}
