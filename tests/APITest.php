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

    final public function testAPIhandleServerRequest_When_PUTMethod_Expect_405Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('PUT', '/.well-known/query'));
        $this->assert405Response($response);
    }
    final public function testAPIhandleServerRequest_When_DELETEMethod_Expect_405Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('DELETE', '/.well-known/query'));
        $this->assert405Response($response);
    }
    final public function testAPIhandleServerRequest_When_HEADMethod_Expect_405Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('HEAD', '/.well-known/query'));
        $this->assert405Response($response);
    }
    final public function testAPIhandleServerRequest_When_OPTIONSMethod_Expect_405Response(): void
    {
        $response = API::handleServerRequest(new ServerRequest('OPTIONS', '/.well-known/query'));
        $this->assert405Response($response);
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
        $this->assertJsonResponse('{"results":[]}', $responseResults);
    }
}
