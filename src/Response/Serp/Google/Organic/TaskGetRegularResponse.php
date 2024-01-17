<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Response\Serp\Google\Organic;

use MarketingToolbox\DataForSEO\Response\ResponseInterface;

final class TaskGetRegularResponse implements ResponseInterface
{
    public function __construct(
        public string $version,
        public int $statusCode,
        public string $statusMessage,
        public string $time,
        public float $cost,
        public int $tasksCount,
        public int $tasksError,

        /** @var list<TaskGetRegularResponseTask> */
        public array $tasks,
    ) {
    }
}

/**
 * @internal
 */
final class TaskGetRegularResponseTask
{
    public function __construct(
        public string $id,
        public int $statusCode,
        public string $statusMessage,
        public string $time,
        public float $cost,
        public int $resultCount,
        public TaskGetRegularResponseTaskData $data,
        /** @var list<TaskGetRegularResponseTaskResult> */
        public array $result,
    ) {
    }
}

/**
 * @internal
 */
final class TaskGetRegularResponseTaskData
{
    public function __construct(
        public string $api,
        public string $function,
        public string $se,
        public string $seType,
        public ?string $keyword,
        public ?string $locationName,
        public ?string $languageCode,
        public ?string $tag,
        public ?string $device,
        public ?string $os,
    ) {
    }
}

/**
 * @internal
 */
final class TaskGetRegularResponseTaskResult
{
    public function __construct(
        public string $keyword,
        public string $type,
        public string $seDomain,
        public int $locationCode,
        public string $languageCode,
        public string $checkUrl,
        public string $datetime,
        public ?string $spell,
        public int $seResultsCount,
        public int $itemsCount,
        /** @var list<TaskGetRegularResponseTaskResultItem> */
        public array $items,
    ) {
    }
}

/**
 * @internal
 */
final class TaskGetRegularResponseTaskResultItem
{
    public function __construct(
        public string $type,
        public int $rankGroup,
        public int $rankAbsolute,
        public string $domain,
        public string $title,
        public string $description,
        public string $url,
        public ?string $breadcrumb,
    ) {
    }
}
