<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Request\Serp\Google\Organic;

use PHPUnit\Framework\TestCase;
use Setono\DataForSEO\Response\Serp\Google\Organic\TaskPostResponse;

final class TaskPostRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_request(): void
    {
        $request = new TaskPostRequest(
            new TaskPostRequestData('herretøj', 'Denmark', 'da'),
            new TaskPostRequestData('lederhosen', 'Germany', 'de'),
        );

        self::assertSame('POST', $request->getMethod());
        self::assertSame('/v3/serp/google/organic/task_post', $request->getEndpoint());
        self::assertSame(TaskPostResponse::class, $request->getResponseClass());

        self::assertSame(
            '[{"keyword":"herret\u00f8j","location_name":"Denmark","language_code":"da"},{"keyword":"lederhosen","location_name":"Germany","language_code":"de"}]',
            json_encode($request, \JSON_THROW_ON_ERROR),
        );
    }
}
