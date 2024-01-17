<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Client;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MarketingToolbox\DataForSEO\Request\RequestInterface;
use MarketingToolbox\DataForSEO\Response\ResponseInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Client implements ClientInterface
{
    private bool $sandbox = false;

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
        $url = sprintf('https://%s.dataforseo.com/%s', $this->sandbox ? 'sandbox' : 'api', ltrim($request->getEndpoint(), '/'));

        $httpRequest = $this->getRequestFactory()
            ->createRequest($request->getMethod(), $url)
            ->withHeader('Accept', 'application/json')
            ->withHeader('User-Agent', 'Marketing Toolbox DataForSEO Client (https://github.com/marketingtoolbox/dataforseo-php-sdk)')
            ->withHeader('Authorization', sprintf('Basic %s', base64_encode($this->login . ':' . $this->password)))
        ;

        if ($request->getMethod() === RequestInterface::METHOD_POST) {
            $json = json_encode($request, \JSON_THROW_ON_ERROR); // todo catch error and throw better exception

            $httpRequest = $httpRequest->withBody($this->getStreamFactory()->createStream($json))
                ->withHeader('Content-Type', 'application/json')
            ;
        }

        $this->lastHttpRequest = $httpRequest;
        $this->lastHttpResponse = $this->getHttpClient()->sendRequest($this->lastHttpRequest);

        return $this->getResponseMapperBuilder()
            ->mapper()
            ->map(
                $request->getResponseClass(),
                Source::json((string) $this->lastHttpResponse->getBody())->camelCaseKeys(),
            );
    }

    public function useSandbox(bool $useSandbox = true): void
    {
        $this->sandbox = $useSandbox;
    }

    private function getHttpClient(): HttpClientInterface
    {
        if (null === $this->httpClient) {
            $this->httpClient = Psr18ClientDiscovery::find();
        }

        return $this->httpClient;
    }

    public function setHttpClient(?HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    public function setRequestFactory(?RequestFactoryInterface $requestFactory): void
    {
        $this->requestFactory = $requestFactory;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }

    public function setStreamFactory(?StreamFactoryInterface $streamFactory): void
    {
        $this->streamFactory = $streamFactory;
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
