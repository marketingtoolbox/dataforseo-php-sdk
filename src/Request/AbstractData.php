<?php

declare(strict_types=1);

namespace MarketingToolboxDataForSEO\Request;

use function Symfony\Component\String\u;

abstract class AbstractData implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        /** @var array<string, mixed> $data */
        $data = [];

        /** @var mixed $value */
        foreach (get_object_vars($this) as $key => $value) {
            if (null === $value) {
                continue;
            }

            /** @psalm-suppress MixedAssignment */
            $data[u($key)->snake()->toString()] = $value;
        }

        return $data;
    }
}
