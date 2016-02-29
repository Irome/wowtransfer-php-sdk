<?php

namespace Wowtransfer\Models;

class User
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
	protected $middleName;

	/**
	 * @var string
	 */
	protected $lastName;

	/**
	 * @var int
	 */
	protected $countryId;

	/**
	 * @var string
	 */
	protected $site;

	/**
	 * @param int $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	/**
	 * @var string
	 */
	public function getName()
	{
		return $this->name;
	}

	public function getMiddleName()
	{
		return $this->middleName;
	}

	/**
	 * @var string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @var int
	 */
	public function getCountryId()
	{
		return $this->countryId;
	}

	/**
	 * @var string
	 */
	public function getSite()
	{
		return $this->site;
	}

	/**
	 * @param string $name
	 * @return \User
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $value
	 * @return \User
	 */
	public function setMiddleName($value)
	{
		$this->middleName = $value;
		return $this;
	}

	/**
	 * @param string $value
	 * @return \User
	 */
	public function setLastName($value)
	{
		$this->lastName = $value;
		return $this;
	}

	/**
	 * @param int $countryId
	 * @return \User
	 */
	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;
		return $this;
	}

	/**
	 * @param string $site
	 * @return \User
	 */
	public function setSite($site)
	{
		$this->site = $site;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
}
