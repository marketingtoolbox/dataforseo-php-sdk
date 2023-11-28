<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MarketingToolbox\DataForSEO\Request\PingbackUrl
 */
final class PingbackUrlTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider provideInputs
     */
    public function it_works(string $url, bool $includeId, bool $includeTag, string $expected): void
    {
        $url = new PingbackUrl($url, $includeId, $includeTag);

        self::assertSame($expected, (string) $url);
    }

    /**
     * @return \Generator<array-key, array{string, bool, bool, string}>
     */
    public function provideInputs(): \Generator
    {
        yield ['https://www.example.com', false, false, 'https://www.example.com'];
        yield ['https://www.example.com', true, false, 'https://www.example.com?id=$id'];
        yield ['https://www.example.com', false, true, 'https://www.example.com?tag=$tag'];
        yield ['https://www.example.com', true, true, 'https://www.example.com?id=$id&tag=$tag'];
        yield ['https://www.example.com/path', true, false, 'https://www.example.com/path?id=$id'];
        yield ['https://www.example.com/path', false, true, 'https://www.example.com/path?tag=$tag'];
        yield ['https://www.example.com/path', true, true, 'https://www.example.com/path?id=$id&tag=$tag'];
        yield ['https://www.example.com?foo=bar', true, false, 'https://www.example.com?foo=bar&id=$id'];
        yield ['https://www.example.com?foo=bar', false, true, 'https://www.example.com?foo=bar&tag=$tag'];
        yield ['https://www.example.com?foo=bar', true, true, 'https://www.example.com?foo=bar&id=$id&tag=$tag'];
        yield ['https://www.example.com?foo=bar&bar=baz', true, false, 'https://www.example.com?foo=bar&bar=baz&id=$id'];
        yield ['https://www.example.com?foo=bar&bar=baz', false, true, 'https://www.example.com?foo=bar&bar=baz&tag=$tag'];
        yield ['https://www.example.com?foo=bar&bar=baz', true, true, 'https://www.example.com?foo=bar&bar=baz&id=$id&tag=$tag'];
    }
}
