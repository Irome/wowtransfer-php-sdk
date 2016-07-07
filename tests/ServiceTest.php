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
		$luaDumpContent = $this->getLuaDumpContent();
		$dump = $this->service->getDump($luaDumpContent);
		$this->assertNotEmpty($dump);
	}

	public function testGetDumpByFields()
	{
		$luaDumpContent = $this->getLuaDumpContent();
		$dump = $this->service->getDump($luaDumpContent, ['player', 'global']);
		$this->assertNotEmpty($dump);
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
		$luaDumpContent = $this->getLuaDumpContent();
		$requestParams = new \Wowtransfer\DumpToSqlParams();
		$requestParams->accountId = 1;
		$requestParams->charactersDb = 'characters';
		$requestParams->dumpLua = $luaDumpContent;
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

	public function testCreateUserDump()
	{
		$luaDumpContent = $this->getLuaDumpContent();
		$this->service->setTest();
		$this->service->createUserDump($luaDumpContent);
		$this->service->setTest(false);
	}

	public function testGetUserDump()
	{
		$dump = $this->service->getUserDump($this->dumpId);
		$this->assertNotEmpty($dump);
	}

	public function testDeleteUserDump()
	{
		$this->service->setTest();
		$this->service->deleteUserDump($this->dumpId);
		$this->service->setTest(false);
	}

	public function testDeleteUserAllDumps()
	{
		$this->service->setTest();
		$this->service->deleteUserAllDumps();
		$this->service->setTest(false);
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

	public function testMessage()
	{
        $this->service->setLanguage('ru');

        $message = 'Empty access token';
        $translatedMessage = $this->service->t($message);
        $this->assertNotEmpty($translatedMessage);

        $message2 = 'This is only english message';
        $translatedMessage2 = $this->service->t($message2);
        $this->assertNotEmpty($translatedMessage2);
	}

	/**
	 * @return string
	 */
	protected function getLuaDumpContent()
	{
		$luaDumpFilePath = __DIR__ . '/dumps/chardumps.lua';
		return file_get_contents($luaDumpFilePath);
	}
}
