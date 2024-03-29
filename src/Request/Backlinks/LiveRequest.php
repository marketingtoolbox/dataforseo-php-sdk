<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Backlinks;

use MarketingToolbox\DataForSEO\Request\AbstractPostRequest;

/**
 * Represents the main backlink request: https://docs.dataforseo.com/v3/backlinks/backlinks/live/
 */
final class LiveRequest extends AbstractPostRequest
{
    /** @var array<array-key, LiveRequestData> */
    private readonly array $data;

    public function __construct(LiveRequestData ...$data)
    {
        $this->endpoint = '/v3/backlinks/backlinks/live';
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
