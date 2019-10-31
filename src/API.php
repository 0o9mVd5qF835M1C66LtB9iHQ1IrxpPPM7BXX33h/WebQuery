<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class API
{
    public static function handleServerRequest(ServerRequestInterface $request): ResponseInterface
    {
        $headers = ['Content-Type' => 'application/json'];
        $body = '{}';
        switch ($request->getMethod()) {
            case 'POST':
                return new Response(201, $headers, $body);
            default:
                return new Response(200, $headers, $body);
        }
    }
}