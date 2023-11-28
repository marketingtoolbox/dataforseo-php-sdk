<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Serp\Google\Organic;

use MarketingToolbox\DataForSEO\Request\AbstractData;

final class TaskPostRequestData extends AbstractData
{
    public function __construct(
        public string $keyword,
        public string $locationName,
        public string $languageCode,
        public ?string $tag = null,
        public ?string $postbackUrl = null,
        public ?string $postbackData = null,
        public ?string $pingbackUrl = null,
    ) {
    }
}
