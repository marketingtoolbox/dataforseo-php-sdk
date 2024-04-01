<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Backlinks;

use PHPUnit\Framework\TestCase;

final class LiveRequestDataTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_defaults(): void
    {
        $data = new LiveRequestData('example.com');
        self::assertSame('example.com', $data->target);
        self::assertSame('live', $data->backlinksStatusType);
        self::assertFalse($data->includeSubdomains);
        self::assertSame(100, $data->limit);
        self::assertNull($data->searchAfterToken);
    }

    /**
     * @test
     */
    public function it_allows_lower_limit(): void
    {
        $data = new LiveRequestData('example.com', limit: 1);
        self::assertSame(1, $data->limit);
    }

    /**
     * @test
     */
    public function it_allows_upper_limit(): void
    {
        $data = new LiveRequestData('example.com', limit: 1000);
        self::assertSame(1000, $data->limit);
    }

    /**
     * @test
     *
     * @dataProvider provideInvalidLimit
     */
    public function it_throws_exception_if_limit_is_not_within_range(int $limit): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Limit must be between 1 and 1000');
        new LiveRequestData('example.com', limit: $limit);
    }

    /**
     * @return \Generator<array-key, array{int}>
     */
    public function provideInvalidLimit(): \Generator
    {
        yield [0];
        yield [1001];
    }
}
