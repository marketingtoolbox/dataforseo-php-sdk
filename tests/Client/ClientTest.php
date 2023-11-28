<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Client;

use PHPUnit\Framework\TestCase;
use Setono\DataForSEO\Request\Serp\Google\Organic\TaskPostRequest;
use Setono\DataForSEO\Request\Serp\Google\Organic\TaskPostRequestData;

/**
 * @covers \Setono\DataForSEO\Client\Client
 */
final class ClientTest extends TestCase
{
    private bool $live = false;

    private ?string $login = null;

    private ?string $password = null;

    protected function setUp(): void
    {
        $this->live = (bool) getenv('LIVE');

        if ($this->live) {
            $this->login = (string) getenv('DATAFORSEO_LOGIN');
            $this->password = (string) getenv('DATAFORSEO_PASSWORD');
        }
    }

    /**
     * @psalm-assert-if-true string $this->login
     * @psalm-assert-if-true string $this->password
     */
    private function isLive(): bool
    {
        return $this->live;
    }

    /**
     * @test
     */
    public function it_receives_response(): void
    {
        if (!$this->isLive()) {
            $this->markTestSkipped('This test is only run in live mode');
        }

        $client = new Client($this->login, $this->password);
        $response = $client->request(new TaskPostRequest(
            new TaskPostRequestData('herretøj', 'Denmark', 'da', 'tag'),
            new TaskPostRequestData('bukser', 'Denmark', 'da'),
        ));

        echo (string) $client->getLastHttpResponse()?->getBody() . "\n\n";

        print_r($response);
    }
}
