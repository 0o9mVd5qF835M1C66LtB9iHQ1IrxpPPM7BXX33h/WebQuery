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

    final public function testAPI() : void
    {
        $response = API::post('hello');
        $this->assertEquals('201', $response->getStatusCode());
    }

}
