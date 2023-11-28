<?php

declare(strict_types=1);

namespace MarketingToolboxDataForSEO\Request;

use function Symfony\Component\String\u;

abstract class AbstractPostRequest extends AbstractRequest implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        /** @var array<string, mixed> $data */
        $data = [];

        /** @var mixed $value */
        foreach (get_object_vars($this) as $key => $value) {
            if (null === $value || 'endpoint' === $key) {
                continue;
            }

            /** @psalm-suppress MixedAssignment */
            $data[u($key)->snake()->toString()] = $value;
        }

        return $data;
    }

    public function getMethod(): string
    {
        return self::METHOD_POST;
    }
}
