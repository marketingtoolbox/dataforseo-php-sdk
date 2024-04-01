<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Request;

use CuyZ\Valinor\Mapper\MappingError;
use Http\Discovery\Psr17FactoryDiscovery;
use MarketingToolbox\DataForSEO\Client\Client;
use MarketingToolbox\DataForSEO\Response\ResponseInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use function Symfony\Component\String\u;
use Webmozart\Assert\Assert;

abstract class AbstractRequestTest extends TestCase
{
    use ProphecyTrait;

    protected Client $client;

    protected function setUp(): void
    {
        $login = getenv('DATAFORSEO_LOGIN');
        Assert::stringNotEmpty($login, 'DATAFORSEO_LOGIN environment variable is not set');

        $password = getenv('DATAFORSEO_PASSWORD');
        Assert::stringNotEmpty($password, 'DATAFORSEO_PASSWORD environment variable is not set');

        $this->client = new Client($login, $password);

        if (!file_exists($this->getResponseFilename())) {
            try {
                $this->client->request($this->getRequest());
            } catch (\Throwable) {
            }

            file_put_contents(
                $this->getResponseFilename(),
                (string) $this->client->getLastHttpResponse()?->getBody(),
            );
        }
    }

    /**
     * @test
     */
    public function it_works(): void
    {
        $request = $this->getRequest();
        $this->requestAssertions($request);

        $httpResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200, 'OK')->withBody(
            Psr17FactoryDiscovery::findStreamFactory()->createStream(file_get_contents($this->getResponseFilename())),
        );

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->sendRequest(Argument::type(HttpRequestInterface::class))->willReturn($httpResponse);

        $this->client->setHttpClient($httpClient->reveal());

        try {
            $response = $this->client->request($request);
        } catch (MappingError $error) {
            // Get flatten list of all messages through the whole nodes tree
//            $messages = \CuyZ\Valinor\Mapper\Tree\Message\Messages::flattenFromNode(
//                $error->node(),
//            );
//
//            // If only errors are wanted, they can be filtered
//            $errorMessages = $messages->errors();
//
//            foreach ($errorMessages as $message) {
//                echo $message->node()->type() . "\n";
//                echo $message->node()->name() . "\n";
//                echo $message->node()->path() . "\n";
//                echo $message->node()->mappedValue() . "\n";
//                echo $message->node()->sourceValue() . "\n";
//            }

            throw $error;
        }

        $expectedRequestJson = $this->getExpectedRequestJson();
        if (null !== $expectedRequestJson) {
            self::assertSame($expectedRequestJson, $this->client->getLastHttpRequest()?->getBody()->getContents());
        }

        $this->responseAssertions($response);
    }

    abstract protected function getRequest(): RequestInterface;

    /**
     * Must return the expected JSON string that is sent to the respective endpoint or null if the request is not a POST request
     */
    protected function getExpectedRequestJson(): ?string
    {
        return null;
    }

    protected function getResponseFilename(): string
    {
        $requestReflection = new \ReflectionClass(static::class);
        $requestFilename = $requestReflection->getFileName();
        self::assertNotFalse($requestFilename);

        return u($requestFilename)->trimSuffix('.php')->append('.json')->toString();
    }

    protected function requestAssertions(RequestInterface $request): void
    {
    }

    protected function responseAssertions(ResponseInterface $response): void
    {
    }
}
