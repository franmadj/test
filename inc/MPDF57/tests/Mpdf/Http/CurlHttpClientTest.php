<?php

namespace Mpdf\Http;

use Mpdf\Mpdf;
use Mpdf\PsrHttpMessageShim\Request;
use Psr\Logg\NullLogger;

class CurlHttpClientTest extends \Yoast\PHPUnitPolyfills\TestCases\TestCase
{

	public function testSendRequest()
	{
		$client = new CurlHttpClient(new Mpdf(), new  NullLogger());

		$response = $client->sendRequest(new Request('GET', 'http://example.com/'));

		self::assertSame(200, $response->getStatusCode());
	}

}
