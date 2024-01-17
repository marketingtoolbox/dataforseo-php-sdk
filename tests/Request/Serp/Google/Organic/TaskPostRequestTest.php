<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Serp\Google\Organic;

use MarketingToolbox\DataForSEO\Request\AbstractRequestTest;
use MarketingToolbox\DataForSEO\Request\RequestInterface;
use MarketingToolbox\DataForSEO\Response\ResponseInterface;
use MarketingToolbox\DataForSEO\Response\Serp\Google\Organic\TaskPostResponse;

final class TaskPostRequestTest extends AbstractRequestTest
{
    protected function requestAssertions(RequestInterface $request): void
    {
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/v3/serp/google/organic/task_post', $request->getEndpoint());
        self::assertSame(TaskPostResponse::class, $request->getResponseClass());
    }

    protected function responseAssertions(ResponseInterface $response): void
    {
        self::assertInstanceOf(TaskPostResponse::class, $response);
        self::assertCount(2, $response->tasks);
        self::assertSame(20000, $response->statusCode);
        self::assertSame('Ok.', $response->statusMessage);
        self::assertSame(2, $response->tasksCount);
        self::assertSame(0, $response->tasksError);

        $task = $response->findTaskByTag('tag');
        self::assertNotNull($task);
    }

    protected function getRequest(): RequestInterface
    {
        return new TaskPostRequest(
            new TaskPostRequestData('gryder', 'Denmark', 'da', 'tag'),
            new TaskPostRequestData('töpfe', 'Germany', 'de'),
        );
    }

    protected function getExpectedRequestJson(): string
    {
        return '[{"keyword":"gryder","location_name":"Denmark","language_code":"da","tag":"tag"},{"keyword":"t\u00f6pfe","location_name":"Germany","language_code":"de"}]';
    }
}
