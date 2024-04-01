<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Response\Backlinks;

use MarketingToolbox\DataForSEO\Response\ResponseInterface;

final class LiveResponse implements ResponseInterface
{
    public function __construct(
        public string $version,
        public int $statusCode,
        public string $statusMessage,
        public string $time,
        public float $cost,
        public int $tasksCount,
        public int $tasksError,
        /** @var list<LiveResponseTask> */
        public array $tasks,
    ) {
    }
}

/**
 * @internal
 */
final class LiveResponseTask
{
    public function __construct(
        public string $id,
        public string $statusCode,
        public string $statusMessage,
        public string $time,
        public float $cost,
        public int $resultCount,
        /** @var list<LiveResponseTaskResult> */
        public array $result,
    ) {
    }
}

/**
 * @internal
 */
final class LiveResponseTaskResult
{
    public function __construct(
        public string $target,
        public int $totalCount,
        public int $itemsCount,
        /** @var list<LiveResponseTaskResultItem> */
        public array $items,
        public string $searchAfterToken,
    ) {
    }
}

/**
 * @internal
 */
final class LiveResponseTaskResultItem
{
    public function __construct(
        public string $type,
        public string $domainFrom,
        public string $urlFrom,
        public bool $urlFromHttps,
        public string $domainTo,
        public string $urlTo,
        public bool $urlToHttps,
        public ?string $tldFrom,
        public bool $isNew,
        public bool $isLost,
        public int $backlinkSpamScore,
        public int $rank,
        public int $pageFromRank,
        public int $domainFromRank,
        /** @var list<string> */
        public array $domainFromPlatformTypes,
        public bool $domainFromIsIp,
        public string $domainFromIp,
        public ?string $domainFromCountry,
        public int $pageFromExternalLinks,
        public int $pageFromInternalLinks,
        public int $pageFromSize,
        public ?string $pageFromEncoding,
        public ?string $pageFromLanguage,
        public ?string $pageFromTitle,
        public int $pageFromStatusCode,
        public string $firstSeen,
        public ?string $prevSeen,
        public string $lastSeen,
        public string $itemType,
        /** @var list<string>|null */
        public ?array $attributes,
        public bool $dofollow,
        public bool $original,
        public ?string $alt,
        public ?string $imageUrl,
        public ?string $textPre,
        public ?string $textPost,
        public ?string $semanticLocation,
        public int $linksCount,
        public int $groupCount,
        public bool $isBroken,
        public ?int $urlToStatusCode,
        public ?int $urlToSpamScore,
        public ?string $urlToRedirectTarget,
        public bool $isIndirectLink,
    ) {
    }
}
