<?php

declare(strict_types=1);

namespace MarketingToolboxDataForSEO\Client;

use MarketingToolboxDataForSEO\Request\RequestInterface;
use MarketingToolboxDataForSEO\Response\ResponseInterface;

interface ClientInterface
{
    public function request(RequestInterface $request): ResponseInterface;
}
