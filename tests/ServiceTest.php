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
		$addonId = 2;
		$product = $this->service->getProduct($addonId);
		$this->assertNotEmpty($product);
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

	public function testGetDumps()
	{
		$this->service->getDumps();
	}

	public function testGetDumpsFields()
	{
		$fields = $this->service->getDumpsFields();
		$this->assertNotEmpty($fields);
	}

	public function testDumpToSql()
	{
	}

	public function testGetUserInfo()
	{
		$this->service->getUserInfo();
	}

	public function testAuthByBasic()
	{
		$service = $this->service;
		$accessToken = $service->getAccessToken();

		$service->setAccessToken('');
		$service->setUsername(WowtransferTestCredentials::$username);
		$service->setPassword(WowtransferTestCredentials::$password);

		$service->getUserInfo();

		$service->setUsername('');
		$service->setPassword('');
		$service->setAccessToken($accessToken);
	}

	public function testAuthByAccesToken()
	{
		$service = $this->service;

		$username = $service->getUsername();
		$password = $service->getPassword();
		$accessToken = $service->getAccessToken();

		$service->setAccessToken(WowtransferTestCredentials::$accessToken);

		$service->getUserInfo();

		$service->setAccessToken($accessToken);
		$service->setUsername($username);
		$service->setPassword($password);
	}

	public function testGetUsers()
	{
		$this->service->getUsers();
	}

	/**
	 * @todo id into the config
	 */
	public function testGetUserById()
	{
		$this->service->getUsersById(1);
	}
}
