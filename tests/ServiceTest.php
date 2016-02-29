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

	/**
	 * @var int
	 */
	protected $userId = 3;

	/**
	 * @var int
	 */
	protected $transferConfigId = 14;

	/**
	 * @var int
	 */
	protected $dumpId = 41;

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
		$luaDumpFilePath = __DIR__ . '/dumps/chardumps.lua';
		$requestParams = new \Wowtransfer\DumpToSqlParams();
		$requestParams->accountId = 1;
		$requestParams->charactersDb = 'characters';
		$requestParams->dumpLua = file_get_contents($luaDumpFilePath);
		$requestParams->transferConfigName = $this->transferConfigId;
		$requestParams->transferOptions = ['achievement'];

		$sql = $this->service->dumpToSql($requestParams);
		$this->assertNotEmpty($sql);
	}

	public function testGetUserInfo()
	{
		$this->service->getUserInfo();
	}

	public function testGetUserTransferConfigs()
	{
		$this->service->getUserTransferConfigs();
	}

	public function testGetUserTransferConfig()
	{
		$config = $this->service->getUserTransferConfig($this->transferConfigId);
		$this->assertNotEmpty($config);
	}

	public function testGetUserDumps()
	{
		$this->service->getUserDumps();
	}

	public function testGetUserDump()
	{
		$dump = $this->service->getUserDump($this->dumpId);
		$this->assertNotEmpty($dump);
	}

	public function testGetUserDumpOneField()
	{
		$fieldName = 'global';
		$dump = $this->service->getUserDump($this->dumpId, $fieldName);
		$this->assertNotEmpty($dump);
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

	public function testGetUsersTransferConfigurations()
	{
		$this->service->getUsersTransferConfigurations($this->userId);
	}

	public function testGetUsersTransferConfiguration()
	{
		$this->service->getUsersTransferConfiguration($this->userId, $this->transferConfigId);
	}

	public function testGetUsersDumps()
	{
		$this->service->getUsersDumps($this->userId);
	}

	public function testGetUsersDump()
	{
		$this->service->getUsersDump($this->userId, $this->dumpId);
	}

	public function testGetUsersDumpOneField()
	{
		$fieldName = 'global';
		$this->service->getUsersDump($this->userId, $this->dumpId, $fieldName);
	}

	/**
	 * @todo id into the config
	 */
	public function testGetUserById()
	{
		$this->service->getUsersById(1);
	}

	public function testUpdateUser()
	{
		$user = new \Wowtransfer\Models\User($this->userId);
		$user->setName('Test');
		$user->setLastName('TestLastName');
		$this->service->updateUser($user);
	}
}
