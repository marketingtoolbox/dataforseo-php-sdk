<?php

declare(strict_types=1);

namespace MarketingToolboxDataForSEO\Request;

use MarketingToolboxDataForSEO\Response\ResponseInterface;

interface RequestInterface
{
    final public const METHOD_GET = 'GET';

    final public const METHOD_POST = 'POST';

    public function getMethod(): string;

    public function getEndpoint(): string;

    /**
     * @return class-string<ResponseInterface>
     */
    public function getResponseClass(): string;
}
