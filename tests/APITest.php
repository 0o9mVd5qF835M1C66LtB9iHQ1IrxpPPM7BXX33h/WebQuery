<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class APITest extends TestCase
{
    final public function testSanity(): void
    {
        $this->assertTrue(true);
    }

    final public function testAPIhandle() : void
    {
        $response = API::handle('GET');
        $this->assertEquals(200, $response->getStatusCode());
    }

    final public function testAPIhandleServerRequestPOST() : void
    {
        $response = API::handleServerRequest(new ServerRequest('POST', '/.well-known/query?q=hello'));
        $this->assertEquals(201, $response->getStatusCode());
    }
}
