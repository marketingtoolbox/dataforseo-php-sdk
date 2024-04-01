<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Backlinks;

use MarketingToolbox\DataForSEO\Request\AbstractData;
use Webmozart\Assert\Assert;

final class LiveRequestData extends AbstractData
{
    public function __construct(
        public readonly string $target,
        public readonly string $backlinksStatusType = 'live',
        public readonly bool $includeSubdomains = false,
        public readonly int $limit = 100,
        public ?string $searchAfterToken = null,
    ) {
        Assert::range($limit, 1, 1000, 'Limit must be between 1 and 1000');
    }
}
