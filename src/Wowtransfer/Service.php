<?php

namespace Wowtransfer;

use Wowtransfer\Exceptions\ServiceException;
use Wowtransfer\WowServer;
use Wowtransfer\Realm;
use Wowtransfer\Product;
use Wowtransfer\Config;

/**
 * Main class of the service
 */
class Service
{

	const TCONFIG_TYPE_PRIVATE = 0;
	const TCONFIG_TYPE_PUBLIC  = 1;

	const LANG_RU = 'ru';
	const LANG_EN = 'en';

	const LUA_MIME_TYPE = 'application/x-lua';

	/**
	 * @var string API Base url, without / on end
	 */
	private $serviceBaseUrl = 'http://wowtransfer.com/api/v1';

	/**
	 * @var string
	 */
	private $accessToken;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	protected $language;

	/**
	 * @var array
	 */
	protected $cores;

	/**
	 * @var Product[]
	 */
	protected $products;

	/**
	 * @var string[]
	 */
	protected $dumpsFields;

	/**
	 * @var \Wowtransfer\HttpClient
	 */
	private $httpClient;

	public function __construct($accessToken)
	{
		if (empty($accessToken)) {
			throw new ServiceException('Empty access token');
		}
		$this->accessToken = $accessToken;

		$config = Config::getInstance();
		if ($config->getServiceBaseUrl()) {
			$this->serviceBaseUrl = $config->getServiceBaseUrl();
		}

		$this->httpClient = new \Wowtransfer\HttpClient();
	}

	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param string $value
	 * @return \Wowtransfer
	 */
	public function setLanguage($value)
	{
		$this->language = $value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * @param string $token
	 * @return \Wowtransfer\Service
	 */
	public function setAccessToken($token)
	{
		$this->accessToken = $token;
		return $this;
	}

	/**
	 * @param string $username
	 * @return \Wowtransfer\Service
	 */
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $password
	 * @return \Wowtransfer\Service
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $url
	 * @return Service
	 */
	public function setBaseUrl($url)
	{
		if (empty($url)) {
			throw new ServiceException('Empty base url');
		}

		if ($url[strlen($url) - 1] === '/') {
			$url = substr($url, 0, -1);
		}
		$this->serviceBaseUrl = $url;

		return $this;
	}

	/**
	 * @return string API Base url, without '/' on end
	 */
	public function getBaseUrl()
	{
		return $this->serviceBaseUrl;
	}

	/**
	 * @param string $uri Example '/dumps', '/dumps/', 'dumps'
	 * @return string Example http://wowtransfer.com/api/v1/dumps/
	 */
	private function getApiUrl($uri, $params = [])
	{
		if ($uri{0} !== '/') {
			$uri = '/' . $uri;
		}
		/*$params = '';
		if (($paramPos = strpos($uri, '?')) !== false) {
			$params = substr($uri, $paramPos);
			$uri = substr($uri, 0, $paramPos);
		}*/
		$url = $this->getBaseUrl() . $uri;
		if ($url{strlen($url) - 1} !== '/') {
			$url .= '/';
		}
		if ($params) {
			$url .= '?' . http_build_query($params);
		}

		return $url;
	}

	/**
	 * @return string Actual version of API
	 */
	public function getApiVersion()
	{
		return '1.0';
	}

	/**
	 * @return array
	 * @throws \Wowtransfer\Exceptions\ServiceException
	 */
	public function getCores()
	{
		if ($this->cores === null) {
			$url = $this->getApiUrl('/cores');
			$response = $this->httpClient->send($url);
			$errorMessage = "Could't get cores from the service";
			$this->checkDecodedResponse($response, $errorMessage);
			$this->cores = $response->getDecodedBody();
		}
		return $this->cores;
	}

	/**
	 * Check success status and JSON decoding
	 *
	 * @param \Wowtransfer\Response $response
	 * @throws \Wowtransfer\Extensions\ServiceException
	 */
	protected function checkDecodedResponse($response, $errorMessage = null)
	{
		$this->checkResponse($response, $errorMessage);
		if ($response->getDecodedBody() === null) {
			throw new ServiceException($errorMessage);
		}
	}

	/**
	 * @param \Wowtransfer\Response $response
	 * @param string $errorMessage
	 * @throws \Wowtransfer\Extensions\ServiceException
	 */
	protected function checkResponse($response, $errorMessage = null)
	{
		if ($response->getHttpStatusCode() !== 200) {
			$decodedBody = $response->getDecodedBody();
			if (isset($decodedBody['error_message'])) {
				throw new ServiceException($decodedBody['error_message']);
			}
			if ($errorMessage) {
				$errorMessage .= ', response status code ' . $response->getHttpStatusCode();
			}
			else {
				$errorMessage = 'Response status code ' . $response->getHttpStatusCode();
			}
			throw new ServiceException($errorMessage);
		}
	}

	/**
	 * @return array
	 */
	public function getDumps()
	{
		$url = $this->getApiUrl('/dumps');
		$response = $this->httpClient->send($url);
		$errorMessage = "Could't retrieve public dumps";
		$this->checkDecodedResponse($response, $errorMessage);
		return $response->getDecodedBody();
	}

	/**
	 * @return string[]
	 */
	public function getDumpsFields()
	{
		if ($this->dumpsFields === null) {
			$url = $this->getApiUrl('/dumps/fields');
			$response = $this->httpClient->send($url);
			$errorMessage = "Could't retrieve dumps fields";
			$this->checkDecodedResponse($response, $errorMessage);
			$this->dumpsFields = $response->getDecodedBody();
		}
		return $this->dumpsFields;
	}

	/**
	 * @param string $luaDumpContent
	 * @param array $fields
	 * @return array
	 * @throws \Wowtransfer\Exceptions\ServiceException
	 */
	public function getDump($luaDumpContent, $fields = [])
	{
		if (empty($luaDumpContent)) {
			throw new ServiceException('Empty dump content');
		}
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w');
		if (!$file) {
			throw new ServiceException('Couldn`t open file ' . $filePath);
		}
		fwrite($file, $luaDumpContent);
		fclose($file);

		$dumpFile = new CURLFile($filePath, self::LUA_MIME_TYPE, 'chardumps.lua');
		$postFields = [
			'dump_lua' => $dumpFile,
			'fields' => implode(',', $fields),
		];
		$url = $this->getApiUrl('/dumps/fields');
		$headers = ['Content-type: multipart/form-data'];
		$response = $this->httpClient->send($url, 'POST', $postFields, $headers);

		$errorMessage = "Couldn't read player dump from JSON";
		$this->checkDecodedResponse($response, $errorMessage);

		unlink($filePath);

		return $response->getDecodedBody();
	}

	/**
	 * @return array
	 */
	public function getTransferConfigs()
	{
		$url = $this->getApiUrl('/tconfigs');
		$response = $this->httpClient->send($url);
		$errorMessage = "Couldn't get transfer configurations from service";
		$this->checkDecodedResponse($response, $errorMessage);
		return $response->getDecodedBody();
	}

	/**
	 * @param integer $id Identifier of trasnfer configuration
	 * @return array
	 */
	public function getTransferConfig($id)
	{
		$tconfigId = (int) $id;
		$params = ['access_token' => $this->getAccessToken()];
		$url = $this->getApiUrl('/user/tconfigs/' . $tconfigId, $params);
		$response = $this->httpClient->send($url);
		$errorMessage = "Could't get transfer configuration #$tconfigId from service";
		$this->checkDecodedResponse($response, $errorMessage);

		return $response->getDecodedBody();
	}

	/**
	 * Convert lua-dump to SQL script
	 *
	 * @param DumpToSqlParams $params
	 *
	 * @return string Sql
	 */
	public function dumpToSql($params)
	{
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w');
		if (!$file) {
			$message = 'Couldn`t open file ' . $filePath;
			throw new ServiceException($message);
		}
		fwrite($file, gzencode($params->dumpLua));
		fclose($file);

		$dumpFile = new CURLFile($filePath, self::LUA_MIME_TYPE, 'chardumps.lua');
		$postFields = [
			'dump_lua' => $dumpFile,
			'dump_encode' => 'gzip',
			'configuration_id' => $params->transferConfigName,
			'account_id' => $params->accountId,
			'access_token' => $this->getAccessToken(),
			'transfer_options' => implode(';', $params->transferOptions),
		];
		$url = $this->getApiUrl('/dumps/sql');
		$headers = ['Content-type: multipart/form-data'];
		$response = $this->httpClient->send($url, 'POST', $postFields, $headers);

		unlink($filePath);

		$this->checkResponse($response);
		$sql = $response->getBody();
		if (empty($sql)) {
			throw new ServiceException('Empty SQL');
		}

		return $sql;
	}

	/**
	 * @return WowServer[]
	 * @throws ServiceException
	 */
	public function getWowServers()
	{
		$url = $this->getApiUrl('/wowservers');
		$response = $this->httpClient->send($url);
		$errorMessage = "Couldn't retrieve WoW servers from the service";
		$this->checkDecodedResponse($response, $errorMessage);
		$servers = $response->getDecodedBody();

		$wowServers = [];
		foreach ($servers as $server) {
			$wowserver = new WowServer();
			$wowserver
					->setId($server['id'])
					->setName($server['name'])
					->setDescription($server['description'])
					->setSite($server['site_url']);
			foreach ($server['realms'] as $serverRealm) {
				$realm = new Realm();
				$realm
						->setId($serverRealm['id'])
						->setName($serverRealm['name'])
						->setRate($serverRealm['rate'])
						->setOnlineCount($serverRealm['online_count']);
				$wowserver->addRealm($realm);
			}
			$wowServers[] = $wowserver;
		}

		return $wowServers;
	}

	/**
	 * @return Product[]
	 * @throws ServiceException
	 */
	public function getProducts()
	{
		if ($this->products === null) {
			$this->products = [];

			$url = $this->getApiUrl('/products');
			$response = $this->httpClient->send($url);
			$errorMessage = "Couldn't retrieve WoW servers";
			$this->checkDecodedResponse($response, $errorMessage);
			$applicationsSource = $response->getDecodedBody();

			foreach ($applicationsSource as $appItem) {
				$app = new Product($appItem['id_name']);
				$app
						->setId($appItem['id'])
						->setName($appItem['name'])
						->setDescription($appItem['descr'])
						->setDownloadUrl($appItem['download_url'])
						->setUpdatedAt($appItem['updated_at'])
						->setVersion($appItem['version']);
				$this->products[$appItem['id_name']] = $app;
			}
		}
		return $this->products;
	}

	/**
	 * @param string $idName
	 * @return Product|false
	 */
	public function getProduct($idName)
	{
		if (isset($this->products[$idName])) {
			return $this->products[$idName];
		}
		$url = $this->getApiUrl('/products/' . $idName);
		$response = $this->httpClient->send($url);
		$this->checkDecodedResponse($response);
		$appSource = $response->getDecodedBody();

		$product = new Product($idName);
		$product
				->setId($appSource['id'])
				->setName($appSource['name'])
				->setDescription($appSource['descr'])
				->setDownloadUrl($appSource['download_url'])
				->setUpdatedAt($appSource['updated_at'])
				->setVersion($appSource['version']);

		if (!is_array($this->products)) {
			$this->products = [];
		}
		$this->products[$idName] = $product;

		return $product;
	}

	/**
	 * @return array
	 */
	public function getUserInfo()
	{
		$params = ['access_token' => $this->accessToken];
		$headers = [];
		if ($this->username && $this->password) {
			$authValue = base64_encode($this->username . ':' . $this->password);
			$headers[] = 'Authorization: Basic ' . $authValue;
		}
		$url = $this->getApiUrl('/user', $params);
		$response = $this->httpClient->send($url, 'GET', null, $headers);
		$this->checkDecodedResponse($response);
		return $response->getDecodedBody();
	}

	/**
	 * @return array
	 */
	public function getUserTransferConfigs()
	{
		$params = ['access_token' => $this->accessToken];
		$headers = [];
		if ($this->username && $this->password) {
			$authValue = base64_encode($this->username . ':' . $this->password);
			$headers[] = 'Authorization: Basic ' . $authValue;
		}
		$url = $this->getApiUrl('/user/tconfigs', $params);
		$response = $this->httpClient->send($url, 'GET', null, $headers);
		$this->checkDecodedResponse($response);
		return $response->getDecodedBody();
	}

	/**
	 * @return array
	 */
	public function getUserTransferConfig($id)
	{
		$params = ['access_token' => $this->accessToken];
		$headers = [];
		if ($this->username && $this->password) {
			$authValue = base64_encode($this->username . ':' . $this->password);
			$headers[] = 'Authorization: Basic ' . $authValue;
		}
		$url = $this->getApiUrl('/user/tconfigs/' . $id, $params);
		$response = $this->httpClient->send($url, 'GET', null, $headers);
		$this->checkDecodedResponse($response);
		return $response->getDecodedBody();
	}

	/**
	 * @return array
	 */
	public function getUserDumps()
	{
		$params = ['access_token' => $this->accessToken];
		$headers = [];
		if ($this->username && $this->password) {
			$authValue = base64_encode($this->username . ':' . $this->password);
			$headers[] = 'Authorization: Basic ' . $authValue;
		}
		$url = $this->getApiUrl('/user/dumps', $params);
		$response = $this->httpClient->send($url, 'GET', null, $headers);
		$this->checkDecodedResponse($response);
		return $response->getDecodedBody();
	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function getUserDump($id)
	{
		$params = ['access_token' => $this->accessToken];
		$headers = [];
		if ($this->username && $this->password) {
			$authValue = base64_encode($this->username . ':' . $this->password);
			$headers[] = 'Authorization: Basic ' . $authValue;
		}
		$url = $this->getApiUrl('/user/dumps/' . $id, $params);
		$response = $this->httpClient->send($url, 'GET', null, $headers);
		$this->checkDecodedResponse($response);
		return $response->getDecodedBody();
	}

	/**
	 * @param int $pageNumber Start with 1
	 * @param int $perPage
	 * @return array
	 */
	public function getUsers($pageNumber = 1, $perPage = 100)
	{
		$params = [
			'page' => $pageNumber,
			'per_page' => $perPage,
		];
		$url = $this->getApiUrl('/users', $params);
		$response = $this->httpClient->send($url);
		$errorMessage = "Couldn't retrieve users";
		$this->checkDecodedResponse($response, $errorMessage);
		return $response->getDecodedBody();
	}

	/**
	 * @return array
	 */
	public function getUsersById($userId)
	{
		if (empty($userId)) {
			throw new \Wowtransfer\Exceptions\ServiceException('Empty user id');
		}
		$url = $this->getApiUrl('/users/' . $userId);
		$response = $this->httpClient->send($url);
		$errorMessage = "Couldn't retrieve user by id";
		$this->checkDecodedResponse($response, $errorMessage);
		return $response->getDecodedBody();
	}
}

/**
 * DTO to Wowtransfer::dumpToSql method
 */
class DumpToSqlParams
{

	/** @var string */
	public $dumpLua;

	/** @var int */
	public $accountId;

	/** @var string */
	public $transferConfigName;

	/** @var string The transfer options separated by semicolon */
	public $transferOptions;

	/** @var string */
	public $charactersDb;

}
