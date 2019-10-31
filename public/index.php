<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$response = \rikmeijer\WebQuery\API::handle($_SERVER['REQUEST_METHOD'], $_REQUEST);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
if ($response->getStatusCode() !== 304) {
    print $response->getBody();
}
exit;

