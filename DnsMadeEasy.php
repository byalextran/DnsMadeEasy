<?php
require_once 'DnsMadeEasyException.php';

class DnsMadeEasy
{
	private $_apiKey;
	private $_secretKey;
	private $_testing;
	private $_requestLimit;
	private $_requestsRemaining;
	private $_headers;
	const BASE_URL = 'http://api.sandbox.dnsmadeeasy.com/V1.2/';

	public function __construct($apiKey, $secretKey, $testing = FALSE)
	{
		if (empty($apiKey)) {
			throw new DnsMadeEasyException('The API key is required.');
		}

		if (empty($secretKey)) {
			throw new DnsMadeEasyException('The Secret Key is required.');
		}

		date_default_timezone_set('UTC');

		$this->_apiKey = $apiKey;
		$this->_secretKey = $secretKey;
		$this->_testing = $testing;
		$this->_headers = array();
	}

	public function getDomains()
	{
		$ch = curl_init();

		if (empty($ch)) {
			throw new DnsMadeEasyException('Unable to initialize a new cURL session.');
		}

		$requestDate = date('r');
		$headers = array(
			"x-dnsme-apiKey: $this->_apiKey",
			"x-dnsme-requestDate: $requestDate",
			'x-dnsme-hmac: ' . $this->_hmac($requestDate),
		);

		curl_setopt($ch, CURLOPT_URL, 'http://api.sandbox.dnsmadeeasy.com/V1.2/domains');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, '_curlHeaderCallback'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$output = curl_exec($ch);

		if (($errno = curl_errno($ch)) > 0)
		{
		    throw new DnsMadeEasyException(curl_error($ch), $errno);
		}

		$httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpResponseCode != 200) {
			throw new DnsMadeEasyException('Invalid HTTP response code.', $httpResponseCode);
		}

		curl_close($ch);

		$domains = json_decode($output, TRUE);

		if (!empty($domains['list'])) {
			$domains = $domains['list'];
		}

		return $domains;
	}

	public function getRequestLimit()
	{
		return (int) $this->_headers['x-dnsme-requestLimit'];
	}

	public function getRequestsRemaining()
	{
		return (int) $this->_headers['x-dnsme-requestsRemaining'];
	}

	public function getRequestId()
	{
		return $this->_headers['x-dnsme-requestId'];
	}

	private function _hmac($requestDate)
	{
		if (empty($requestDate)) {
			throw new DnsMadeEasyException('The request date is required.');
		}

		return hash_hmac('sha1', $requestDate, $this->_secretKey);
	}

	private function _curlHeaderCallback($ch, $header)
	{
		$length = strlen($header);

		if (empty($header)) {
			return $length;
		}

		$split = explode(':', $header);

		if (count($split) < 2) {
			return $length;
		}

		$this->_headers[$split[0]] = trim($split[1]);

		return $length;

	}
}
?>
