<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class API
{

    public static function handle(): ResponseInterface
    {
        return new Response(201);
    }
}