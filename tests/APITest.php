<?php
declare(strict_types=1);

namespace rikmeijer\WebQuery;

use PHPUnit\Framework\TestCase;

class APITest extends TestCase
{
    final public function testSanity() : void
    {
        $this->assertTrue(true);
    }

    final public function testAPIhandle() {
        $response = API::handle('POST', ['q' => 'hello']);
        $this->assertEquals('201', $response->getStatusCode());
        $this->assertCount(0, $response->getHeaders());
    }

}
