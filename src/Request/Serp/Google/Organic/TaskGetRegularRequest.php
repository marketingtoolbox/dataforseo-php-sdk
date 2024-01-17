<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request\Serp\Google\Organic;

use MarketingToolbox\DataForSEO\Request\AbstractGetRequest;

final class TaskGetRegularRequest extends AbstractGetRequest
{
    public function __construct(string $id)
    {
        $this->endpoint = sprintf('/v3/serp/google/organic/task_get/regular/%s', $id);
    }
}
