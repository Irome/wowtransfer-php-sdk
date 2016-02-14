<?php

namespace Wowtransfer;

class Response
{
	/**
	 * @var int
	 */
	protected $httpStatusCode;

	/**
	 * @var string
	 */
	protected $body;

	/**
	 * @var array|null
	 */
	protected $decodedBody;

	/**
	 * @var array
	 */
	protected $headers;

	public function __construct($body, $httpStatusCode)
	{
		$this->httpStatusCode = (int)$httpStatusCode;
		$this->body = $body;

		$this->decodeBody();
	}

	/**
	 * @return int
	 */
	public function getHttpStatusCode()
	{
		return $this->httpStatusCode;
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @return array
	 */
	public function getDecodedBody()
	{
		return $this->decodedBody;
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @param type $httpStatusCode
	 * @return \Wowtransfer\Response
	 */
	public function setHttpStatusCode($httpStatusCode)
	{
		$this->httpStatusCode = $httpStatusCode;
		return $this;
	}

	/**
	 * @param string $body
	 * @return \Wowtransfer\Response
	 */
	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	/**
	 * @param array $headers
	 * @return \Wowtransfer\Response
	 */
	public function setHeaders($headers)
	{
		$this->headers = $headers;
		return $this;
	}

	/**
	 * Convert raw body from JSON to array
	 */
	public function decodeBody()
	{
		$this->decodedBody = json_decode($this->body);
	}
}