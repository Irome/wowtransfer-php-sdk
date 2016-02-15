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

	public function testGetWowServers()
	{
		$this->service->getWowServers();
	}

	public function testGetWowServer()
	{
	}

	public function testGetCores()
	{
		$cores = $this->service->getCores();
		$this->assertNotEmpty($cores);
	}

	public function testGetProducts()
	{
		$products = $this->service->getProducts();
		$this->assertNotEmpty($products);
	}

	public function testGetProduct()
	{
	}

	public function testGetTransferConfigs()
	{
		$this->service->getTransferConfigs();
	}

	public function testGetTransferConfig()
	{
	}

	public function testGetDump()
	{
	}

	public function testDumpToSql()
	{
	}
}
