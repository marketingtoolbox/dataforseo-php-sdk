<?php

declare(strict_types=1);

namespace MarketingToolbox\DataForSEO\Client;

use MarketingToolbox\DataForSEO\Request\RequestInterface;
use MarketingToolbox\DataForSEO\Response\ResponseInterface;

interface ClientInterface
{
    public function request(RequestInterface $request): ResponseInterface;
}
