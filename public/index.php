<?php
declare(strict_types=1);

use GuzzleHttp\Psr7\ServerRequest;
use rikmeijer\WebQuery\API;

require dirname(__DIR__) . '/vendor/autoload.php';

$response = API::handleServerRequest(ServerRequest::fromGlobals());
http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
if ($response->getStatusCode() !== 304) {
    print $response->getBody();
}
exit;

