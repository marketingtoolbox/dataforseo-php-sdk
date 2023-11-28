<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Request\Serp\Google\Organic;

use Setono\DataForSEO\Request\AbstractPostRequest;

final class TaskPostRequest extends AbstractPostRequest
{
    /** @var array<array-key, TaskPostRequestData> */
    private array $data;

    public function __construct(TaskPostRequestData ...$data)
    {
        $this->endpoint = '/v3/serp/google/organic/task_post';

        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
