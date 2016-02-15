<?php

namespace Wowtransfer;

use Wowtransfer\Response;
use Wowtransfer\Exceptions\ServiceException;

class HttpClient
{
	/**
	 * @var resource Curl handle
	 */
	private $curlHandle;

	/**
	 * @param string $url
	 * @param string $method
	 * @param string|null $body
	 * @param array $headers
	 * @return \Wowtransfer\Response
	 */
	public function send($url, $method = 'GET', $body = null, $headers = [])
	{
		$this->curlHandle = curl_init();
		$initOptions = [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 10,
            //CURLOPT_TIMEOUT => $timeOut,
            //CURLOPT_HEADER => true, // Enable header processing
            //CURLOPT_SSL_VERIFYHOST => 2,
            //CURLOPT_SSL_VERIFYPEER => true,
		];
		if ($method !== 'GET') {
            $initOptions[CURLOPT_POSTFIELDS] = $body;
        }
		if ($headers) {
			$initOptions[CURLOPT_HTTPHEADER] = $headers;
		}
		curl_setopt_array($this->curlHandle, $initOptions);

		$rawBody = curl_exec($this->curlHandle);

		$curlErrorCode = curl_errno($this->curlHandle);
		if ($curlErrorCode) {
			throw new ServiceException(curl_error($this->curlHandle), $curlErrorCode);
		}
		$httpStatusCode = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);

		curl_close($this->curlHandle);

		return new Response($rawBody, $httpStatusCode);
	}
}
