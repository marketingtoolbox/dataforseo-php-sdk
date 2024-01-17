<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Response\Serp\Google\Organic;

use MarketingToolbox\DataForSEO\Response\ResponseInterface;

final class TaskPostResponse implements ResponseInterface
{
    public function __construct(
        public string $version,
        public int $statusCode,
        public string $statusMessage,
        public string $time,
        public float $cost,
        public int $tasksCount,
        public int $tasksError,

        /** @var list<TaskPostResponseTask> */
        public array $tasks,
    ) {
    }

    /**
     * Returns the first task with the given tag
     */
    public function findTaskByTag(string $tag): ?TaskPostResponseTask
    {
        foreach ($this->tasks as $task) {
            if ($task->data->tag === $tag) {
                return $task;
            }
        }

        return null;
    }
}

/**
 * @internal
 */
final class TaskPostResponseTask
{
    public function __construct(
        public string $id,
        public int $statusCode,
        public string $statusMessage,
        public string $time,
        public float $cost,
        public int $resultCount,
        public TaskPostResponseTaskData $data,
    ) {
    }
}

/**
 * @internal
 */
final class TaskPostResponseTaskData
{
    public function __construct(
        public string $api,
        public string $function,
        public string $se,
        public string $seType,
        public string $keyword,
        public string $locationName,
        public string $languageCode,
        public ?string $tag,
        public ?string $device,
        public ?string $os,
    ) {
    }
}
