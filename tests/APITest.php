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
        $this->assertJsonStringEqualsJsonString($expectedJson, (string)$response->getBody());
    }

    private function assert405Response(ResponseInterface $response) : void {
        $this->assertEquals(405, $response->getStatusCode());
        $this->assertEmpty((string)$response->getBody());
    }

    final public function testSanity(): void
    {
        $this->assertTrue(true);
    }


    /**
     * @dataProvider disallowedMethods
     */
    final public function testAPIhandleServerRequest_When_DisallowedMethod_Expect_405Response(string $method): void
    {
        $response = API::handleServerRequest(new ServerRequest($method, '/.well-known/query'));
        $this->assert405Response($response);
    }
    final public function disallowedMethods() : array {
        return [
            ['PUT'],
            ['DELETE'],
            ['HEAD'],
            ['OPTIONS'],
        ];
    }


    final public function testAPIhandleServerRequest_When_GETDefaultURI_Expect_200Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('GET', '/.well-known/query'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonResponse('{}', $response);
    }

    final public function testAPIhandleServerRequest_When_GETNonExistingURI_Expect_404Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('GET', '/.well-known/query/NonExisting'));
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertCount(0, $response->getHeaders());
        $this->assertEmpty((string)$response->getBody());
    }

    final public function testAPIhandleServerRequest_When_POSTCreateQuery_Expect_201Response(): void
    {
        $responseCreateQuery = API::handleServerRequest(new ServerRequest('POST', '/.well-known/query?q=hello'));
        $this->assertEquals(201, $responseCreateQuery->getStatusCode());
        $this->assertJsonResponse('{}', $responseCreateQuery);
        $resultsLocation = $responseCreateQuery->getHeader('Location')[0];

        $responseResults = API::handleServerRequest(new ServerRequest('GET', $resultsLocation));
        $this->assertEquals(200, $responseResults->getStatusCode());
        $this->assertJsonResponse('{"results":{}}', $responseResults);
    }
}
