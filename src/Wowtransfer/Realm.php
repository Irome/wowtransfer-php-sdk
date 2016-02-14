<?php

namespace Wowtransfer;

class Realm
{

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var int
	 */
	protected $onlineCount;

	/**
	 * @var int
	 */
	protected $rate;

	/**
	 * @var string
	 */
	protected $wowVersion;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getOnlineCount()
	{
		return $this->onlineCount;
	}

	/**
	 * @return int
	 */
	public function getRate()
	{
		return $this->rate;
	}

	/**
	 * @return string
	 */
	public function getWowVersion()
	{
		return $this->wowVersion;
	}

	/**
	 * @param int $id
	 * @return \Realm
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $name
	 * @return \Realm
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param int $onlineCount
	 * @return \Realm
	 */
	public function setOnlineCount($onlineCount)
	{
		$this->onlineCount = $onlineCount;
		return $this;
	}

	/**
	 * @param string $rate
	 * @return \Realm
	 */
	public function setRate($rate)
	{
		$this->rate = $rate;
		return $this;
	}

	/**
	 * @param string $wowVersion
	 * @return \Realm
	 */
	public function setWowVersion($wowVersion)
	{
		$this->wowVersion = $wowVersion;
		return $this;
	}
}
