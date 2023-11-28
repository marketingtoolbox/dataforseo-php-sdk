<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Client;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Setono\DataForSEO\Request\RequestInterface;
use Setono\DataForSEO\Response\ResponseInterface;

final class Client implements ClientInterface
{
    private ?HttpRequestInterface $lastHttpRequest = null;

    private ?HttpResponseInterface $lastHttpResponse = null;

    private ?HttpClientInterface $httpClient = null;

    private ?RequestFactoryInterface $requestFactory = null;

    private ?StreamFactoryInterface $streamFactory = null;

    private ?MapperBuilder $mapperBuilder = null;

    public function __construct(
        private readonly string $login,
        private readonly string $password,
    ) {
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        $url = sprintf('https://api.dataforseo.com/%s', ltrim($request->getEndpoint(), '/'));

        $psrRequest = $this->getRequestFactory()
            ->createRequest($request->getMethod(), $url)
            ->withHeader('Accept', 'application/json')
            ->withHeader('User-Agent', 'Marketing Toolbox DataForSEO Client (https://github.com/marketingtoolbox/dataforseo-php-sdk)')
            ->withHeader('Authorization', sprintf('Basic %s', base64_encode($this->login . ':' . $this->password)))
        ;

        if (RequestInterface::METHOD_POST === $request->getMethod()) {
            $json = json_encode($request, \JSON_THROW_ON_ERROR); // todo catch error and throw better exception

            $psrRequest = $psrRequest->withBody($this->getStreamFactory()->createStream($json))
                ->withHeader('Content-Type', 'application/json')
            ;
        }

        $this->lastHttpRequest = $psrRequest;
        $this->lastHttpResponse = $this->getHttpClient()->sendRequest($this->lastHttpRequest);

        return $this->getResponseMapperBuilder()
            ->mapper()
            ->map(
                $request->getResponseClass(),
                Source::json((string) $this->lastHttpResponse->getBody())->camelCaseKeys(),
            );
    }

    public function setHttpClient(?HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    private function getHttpClient(): HttpClientInterface
    {
        if (null === $this->httpClient) {
            $this->httpClient = Psr18ClientDiscovery::find();
        }

        return $this->httpClient;
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    public function setStreamFactory(?StreamFactoryInterface $streamFactory): void
    {
        $this->streamFactory = $streamFactory;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }

    public function setRequestFactory(?RequestFactoryInterface $requestFactory): void
    {
        $this->requestFactory = $requestFactory;
    }

    public function getResponseMapperBuilder(): MapperBuilder
    {
        if (null === $this->mapperBuilder) {
            $this->mapperBuilder = (new MapperBuilder())
                ->enableFlexibleCasting()
                ->allowSuperfluousKeys()
            ;
        }

        return $this->mapperBuilder;
    }

    public function setResponseMapperBuilder(?MapperBuilder $mapperBuilder): void
    {
        $this->mapperBuilder = $mapperBuilder;
    }

    public function getLastHttpRequest(): ?HttpRequestInterface
    {
        return $this->lastHttpRequest;
    }

    public function getLastHttpResponse(): ?HttpResponseInterface
    {
        return $this->lastHttpResponse;
    }
}
