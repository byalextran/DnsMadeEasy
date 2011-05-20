<?php
class DnsMadeEasy_Response
{
	private $_curlInfo;
	private $_body;
	private $_headers;
	private $_errors;

	public function __construct($body, $curlInfo, $headers)
	{
		$this->_body = $body;
		$this->_curlInfo = $curlInfo;
		$this->_headers = $headers;

		$errors = json_decode($body, TRUE);

		if (!empty($errors) && isset($errors['error'])) {
			$this->_errors = $errors['error'];
		}
	}

	public function httpStatusCode()
	{
		return empty($this->_curlInfo['http_code']) ? '' : $this->_curlInfo['http_code'];
	}

	public function url()
	{
		return empty($this->_curlInfo['url']) ? '' : $this->_curlInfo['url'];
	}

	public function body() { return $this->_body; }

	public function requestId()
	{
		return empty($this->_headers['x-dnsme-requestId']) ? '' : $this->_headers['x-dnsme-requestId'];
	}

	public function requestLimit()
	{
		return empty($this->_headers['x-dnsme-requestLimit']) ? '' : $this->_headers['x-dnsme-requestLimit'];
	}

	public function requestsRemaining()
	{
		return empty($this->_headers['x-dnsme-requestsRemaining']) ? '' : $this->_headers['x-dnsme-requestsRemaining'];
	}
}
?>