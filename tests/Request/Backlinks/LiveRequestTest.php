<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Backlinks;

use MarketingToolbox\DataForSEO\Request\AbstractRequestTest;
use MarketingToolbox\DataForSEO\Request\RequestInterface;
use MarketingToolbox\DataForSEO\Response\Backlinks\LiveResponse;
use MarketingToolbox\DataForSEO\Response\ResponseInterface;

class LiveRequestTest extends AbstractRequestTest
{
    protected function getRequest(): RequestInterface
    {
        return new LiveRequest(
            new LiveRequestData(
                'forbes.com',
            ),
        );
    }

    protected function getExpectedRequestJson(): string
    {
        return '[{"target":"forbes.com","backlinks_status_type":"live","include_subdomains":false,"limit":100}]';
    }

    protected function requestAssertions(RequestInterface $request): void
    {
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/v3/backlinks/backlinks/live', $request->getEndpoint());
        self::assertSame(LiveResponse::class, $request->getResponseClass());
    }

    protected function responseAssertions(ResponseInterface $response): void
    {
        self::assertInstanceOf(LiveResponse::class, $response);
        self::assertCount(1, $response->tasks);
        self::assertSame(20000, $response->statusCode);
        self::assertSame('Ok.', $response->statusMessage);
        self::assertSame(1, $response->tasksCount);
        self::assertSame(0, $response->tasksError);
    }
}
