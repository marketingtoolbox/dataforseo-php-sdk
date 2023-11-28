<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MarketingToolbox\DataForSEO\Request\AbstractPostRequest
 */
final class AbstractPostRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_serializes(): void
    {
        $request = new TestPostRequest('property', 'camelCasedProperty');

        self::assertEquals([
            'property' => 'property',
            'camel_cased_property' => 'camelCasedProperty',
        ], $request->jsonSerialize());

        self::assertSame('{"property":"property","camel_cased_property":"camelCasedProperty"}', json_encode($request, \JSON_THROW_ON_ERROR));
    }

    /**
     * @test
     */
    public function it_returns_correct_response_class(): void
    {
        $request = new TestPostRequest('property', 'camelCasedProperty');

        self::assertSame('MarketingToolbox\DataForSEO\\Response\\TestPostResponse', $request->getResponseClass());
    }
}

final class TestPostRequest extends AbstractPostRequest
{
    public ?string $unsetProperty = null;

    public function __construct(
        public string $property,
        public string $camelCasedProperty,
    ) {
        $this->endpoint = '/v3/endpoint';
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getCamelCasedProperty(): string
    {
        return $this->camelCasedProperty;
    }
}
