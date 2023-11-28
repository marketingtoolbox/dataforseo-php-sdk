<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request;

use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;

final class PingbackUrl implements \Stringable
{
    private readonly string $url;

    public function __construct(
        UriInterface|string $url,
        bool $includeId = true,
        bool $includeTag = true,
    ) {
        if (is_string($url)) {
            $url = Uri::new($url);
        }

        $query = (string) $url->getQuery();

        if ($includeId) {
            $query .= '&id=$id';
        }

        if ($includeTag) {
            $query .= '&tag=$tag';
        }

        if ('' !== $query) {
            $url = $url->withQuery(ltrim($query, '&'));
        }

        $this->url = $url->toString();
    }

    public function toString(): string
    {
        return $this->url;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
