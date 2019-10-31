<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class API
{
    public static function handleServerRequest(ServerRequestInterface $request): ResponseInterface
    {
        $headers = ['Content-Type' => 'application/json'];
        switch ($request->getMethod()) {
            case 'POST':
                $headers['Location'] = '/.well-known/query/12345';
                return new Response(201, $headers, '{}');
            case 'GET':
                $response = new Response(200, $headers);
                if ($request->getUri()->getPath() === '/.well-known/query/12345') {
                    return $response->withBody(stream_for('{"results":{}}'));
                }
                if ($request->getUri()->getPath() === '/.well-known/query') {
                    return $response->withBody(stream_for('{}'));
                }
                return new Response(404);

            default:
                return new Response(405);
        }
    }
}