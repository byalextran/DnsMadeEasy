<?php
/**
 * Provides a simple way of accessing relevant data from a DNS Made Easy API call.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy_Response
{
	private $_curlInfo;
	private $_body;
	private $_headers;
	private $_errors;

	/**
	* @param mixed $body The return value of <code>curl_exec()</code>.
	* @param mixed $curlInfo The return value of <code>curl_getinfo()</code>.
	* @param array $headers The HTTP headers returned by the API call.
	*/
	public function __construct($body, $curlInfo, $headers)
	{
		$this->_body = $body;
		$this->_curlInfo = $curlInfo;
		$this->_headers = $headers;
		$this->_errors = FALSE;

		$errors = json_decode($body, TRUE);

		if (!empty($errors) && isset($errors['error'])) {
			$this->_errors = $errors['error'];
		}
	}

	/**
	* @return string The HTTP status code (e.g., 200, 404) of the API call.
	*/
	public function httpStatusCode()
	{
		return empty($this->_curlInfo['http_code']) ? '' : $this->_curlInfo['http_code'];
	}

	/**
	* @return string The URL of the API call.
	*/
	public function url()
	{
		return empty($this->_curlInfo['url']) ? '' : $this->_curlInfo['url'];
	}

	/**
	* @return mixed The response from the API call.
	*/
	public function body() { return $this->_body; }

	/**
	* @return string The unique identifier for the API call.
	*/
	public function requestId()
	{
		return empty($this->_headers['x-dnsme-requestId']) ? '' : $this->_headers['x-dnsme-requestId'];
	}

	/**
	* @return string Maximum number of requests that can be sent before the rate limit is exceeded.
	*/
	public function requestLimit()
	{
		return empty($this->_headers['x-dnsme-requestLimit']) ? '' : $this->_headers['x-dnsme-requestLimit'];
	}

	/**
	* @return string Number of requests remaining before the rate limit is exceeded.
	*/
	public function requestsRemaining()
	{
		return empty($this->_headers['x-dnsme-requestsRemaining']) ? '' : $this->_headers['x-dnsme-requestsRemaining'];
	}

	/**
	* @return array|FALSE The error(s) associated with the API call.
	*/
	public function errors() { return $this->_errors; }
}
?>