<?php

namespace Wowtransfer;

/**
 * The available application of the service
 */
class Product
{

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $idName;

	/**
	 * @var string
	 */
	private $name;

	/**
	 *
	 * @var string
	 */
	private $version;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $updatedAt;

	/**
	 * @var string
	 */
	private $downloadUrl;

	/**
	 * @var string
	 */
	private $docUrl;

	/**
	 * @param string $idName
	 */
	public function __construct($idName)
	{
		$this->idName = $idName;
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
	public function getVersion()
	{
		return $this->version;
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
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @return string
	 */
	public function getDownloadUrl()
	{
		return $this->downloadUrl;
	}

	/**
	 * @return string
	 */
	public function getDocUrl()
	{
		return $this->docUrl;
	}

	/**
	 * @param string $name
	 * @return Product
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $version
	 * @return Product
	 */
	public function setVersion($version)
	{
		$this->version = $version;
		return $this;
	}

	/**
	 * @param string $description
	 * @return Product
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @param string $updatedAt
	 * @return Product
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * @param string $downloadUrl
	 * @return Product
	 */
	public function setDownloadUrl($downloadUrl)
	{
		$this->downloadUrl = $downloadUrl;
		return $this;
	}

	/**
	 * @param string $docUrl
	 * @return Product
	 */
	public function setDocUrl($docUrl)
	{
		$this->docUrl = $docUrl;
		return $this;
	}

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
	public function getIdName()
	{
		return $this->idName;
	}

	/**
	 * @param int $id
	 * @return Product
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $idName
	 * @return Product
	 */
	public function setIdName($idName)
	{
		$this->idName = $idName;
		return $this;
	}

}
