<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request;

abstract class AbstractGetRequest extends AbstractRequest
{
    public function getMethod(): string
    {
        return self::METHOD_GET;
    }
}
