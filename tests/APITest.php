<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class APITest extends TestCase
{
    private function assertJSONResponse(string $expectedJson, ResponseInterface $response): void
    {
        $this->assertEquals('application/json', $response->getHeader('Content-Type')[0]);
        $this->assertJson($expectedJson, $response->getBody()->__toString());
    }

    final public function testSanity(): void
    {
        $this->assertTrue(true);
    }

    final public function testAPIhandleServerRequest_When_GETDefaultURI_Expect_200Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('GET', '/.well-known/query'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonResponse('{}', $response);
    }

    final public function testAPIhandleServerRequest_When_POSTCreateQuery_Expect_201Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('POST', '/.well-known/query?q=hello'));
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonResponse('{}', $response);
    }
}
