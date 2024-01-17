<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Serp\Google\Organic;

use MarketingToolbox\DataForSEO\Request\AbstractRequestTest;
use MarketingToolbox\DataForSEO\Request\RequestInterface;
use MarketingToolbox\DataForSEO\Response\ResponseInterface;
use MarketingToolbox\DataForSEO\Response\Serp\Google\Organic\TaskGetRegularResponse;

final class TaskGetRegularRequestTest extends AbstractRequestTest
{
    protected function requestAssertions(RequestInterface $request): void
    {
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/v3/serp/google/organic/task_get/regular/00000000-0000-0000-0000-000000000000', $request->getEndpoint());
        self::assertSame(TaskGetRegularResponse::class, $request->getResponseClass());
    }

    protected function responseAssertions(ResponseInterface $response): void
    {
        self::assertInstanceOf(TaskGetRegularResponse::class, $response);
        self::assertCount(1, $response->tasks);
        self::assertSame(20000, $response->statusCode);
        self::assertSame('Ok.', $response->statusMessage);
        self::assertSame(1, $response->tasksCount);
        self::assertSame(0, $response->tasksError);

        self::assertCount(1, $response->tasks[0]->result);
        self::assertCount(98, $response->tasks[0]->result[0]->items);
    }

    protected function getRequest(): RequestInterface
    {
        return new TaskGetRegularRequest('00000000-0000-0000-0000-000000000000');
    }
}
