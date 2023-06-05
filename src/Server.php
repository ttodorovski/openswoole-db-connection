<?php

declare(strict_types=1);

namespace Rovski\OpenSwooleDbConnection;

use OpenSwoole\Constant;
use OpenSwoole\Core\Coroutine\Client\PDOClient;
use OpenSwoole\Core\Coroutine\Client\PDOConfig;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

class Server extends \OpenSwoole\Http\Server
{
	private readonly PDOClient $client;

	public function __construct(
		private readonly PDOConfig $dbConfig,
		string $host,
		int $port = 0,
		int $mode = \OpenSwoole\Server::SIMPLE_MODE,
		int $sockType = Constant::SOCK_TCP
	) {
		parent::__construct($host, $port, $mode, $sockType);
	}

	public function start(callable $onRequest = null): bool
	{
		/**
		 * Set the onRequest callback to the parent onRequest callback
		 */
		if ($onRequest) {
			$this->on('workerStart', function (): void {
				$this->client = new PDOClient($this->dbConfig);
			});

			$this->on('request', function (Request $request, Response $response) use ($onRequest): void {
				$onRequest($request, $response, $this->client);
			});
		}

		return parent::start();
	}
}
