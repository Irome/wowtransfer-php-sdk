<?php

namespace Wowtransfer;


/**
 * The World of Warcraft server
 */
class WowServer
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
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $site;

	/**
	 * @var Realm[]
	 */
	protected $realms = [];

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
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getSite()
	{
		return $this->site;
	}

	/**
	 * @param int $id
	 * @return \Wowserver
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $name
	 * @return \Wowserver
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $description
	 * @return \Wowserver
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @param string $site
	 * @return \Wowserver
	 */
	public function setSite($site)
	{
		$this->site = $site;
		return $this;
	}

	/**
	 * @return Realm[]
	 */
	public function getRealms()
	{
		return $this->realms;
	}

	/**
	 * @param Realm $realm
	 */
	public function addRealm($realm)
	{
		$this->realms[] = $realm;
	}

}
