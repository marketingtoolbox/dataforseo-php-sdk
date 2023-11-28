<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Request;

use Setono\DataForSEO\Response\ResponseInterface;

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
