<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;

class API
{

    public static function handle(string $method): ResponseInterface
    {
        switch ($method) {
            case 'POST':
                return new Response(201);
            default:
                return new Response(200);
        }
    }

    public static function handleServerRequest(ServerRequest $request)
    {
        return self::handle($request->getMethod());
    }
}