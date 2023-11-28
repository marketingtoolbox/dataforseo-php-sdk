<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Request;

use Setono\DataForSEO\Response\ResponseInterface;
use function Symfony\Component\String\u;

abstract class AbstractRequest implements RequestInterface
{
    protected string $endpoint;

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getResponseClass(): string
    {
        $baseRequestNamespace = 'Setono\\DataForSEO\\Request\\';
        $baseResponseNamespace = 'Setono\\DataForSEO\\Response\\';

        /** @var class-string<ResponseInterface> $responseClass */
        $responseClass = u(static::class)
            ->trimPrefix($baseRequestNamespace)
            ->prepend($baseResponseNamespace)
            ->trimSuffix('Request')
            ->append('Response')
            ->toString()
        ;

        return $responseClass;
    }
}
