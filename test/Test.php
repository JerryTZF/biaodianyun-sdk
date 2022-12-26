<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Biaodianyun\Sdk\Config;
use Biaodianyun\Sdk\Gateways;
use Biaodianyun\Sdk\Model\Others\DemoRequest;
use Biaodianyun\Sdk\OpenAPIClient;
use GuzzleHttp\Exception\GuzzleException;

$config = new Config();
$config->setGateway(Gateways::OUTSIDE_DEV);
$config->setAccessKey('UI8TY1wc');
$config->setSecret('a8451b2c15c3a46ce1f17eda1d359bc57fcfa326');

$client = new OpenAPIClient($config);

$request = new DemoRequest();
$request->setId(12);
$request->isSSL = true;
$request->isDebug = true;

try {
    $response = $client->send($request);
    var_dump($response);
} catch (GuzzleException|Exception $e) {
    var_dump($e->getMessage());
}
