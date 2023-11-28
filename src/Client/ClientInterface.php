<?php

declare(strict_types=1);

namespace Setono\DataForSEO\Client;

use Setono\DataForSEO\Request\RequestInterface;
use Setono\DataForSEO\Response\ResponseInterface;

interface ClientInterface
{
    public function request(RequestInterface $request): ResponseInterface;
}
