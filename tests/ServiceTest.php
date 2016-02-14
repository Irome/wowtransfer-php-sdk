<?php

namespace Wowtransfer\Tests;

use Wowtransfer\Service;
use Wowtransfer\Tests\WowtransferTestCredentials;

/**
 * Test all api
 * - public global api
 * - authorization
 * - authorizated api
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Wowtransfer\Service
	 */
	private $service;

	public function __construct($name = null, $data = [], $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
		$this->service = new Service(WowtransferTestCredentials::$accessToken);
	}

	public function testGetApiVersion()
	{
		$version = $this->service->getApiVersion();
		$this->assertNotEmpty($version);
	}
}
