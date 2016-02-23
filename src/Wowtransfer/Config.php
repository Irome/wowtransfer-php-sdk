<?php

namespace Wowtransfer;

class Config
{
	/**
	 * @var \Wowtransfer\Config
	 */
	private static $instance;

	/**
	 * @var array
	 */
	private $config;

	private function __construct()
	{
		$mainFilePath = __DIR__ . '/config/main.php';
		$localFilePath = __DIR__ . '/config/main-local.php';

		$config = require $mainFilePath;

		if (file_exists($localFilePath)) {
			$local = require $localFilePath;
			$config = array_merge($config, $local);
		}

		$this->config = $config;
	}

	/**
	 * @return \Wowtransfer\Config
	 */
	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new \Wowtransfer\Config();
		}
		return self::$instance;
	}

	/**
	 * @return string
	 */
	public function getServiceBaseUrl()
	{
		return $this->config['serviceBaseUrl'];
	}
}
