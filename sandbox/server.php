<?php

use OpenSwoole\Core\Coroutine\Client\PDOClient;
use OpenSwoole\Core\Coroutine\Client\PDOConfig;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use Rovski\OpenSwooleDbConnection\Server;

require_once __DIR__ . '/../vendor/autoload.php';

$pdoConnection = new PDOConfig();
$pdoConnection->withHost('db')
	->withDbname('mysql')
	->withUsername('root')
	->withPassword('tester');

$server = new Server($pdoConnection, '0.0.0.0', 9501);
$server->start(function (Request $request, Response $response, PDOClient $client) {
	$client->query('SELECT 1');

	$response->end('Hello World!');
});
