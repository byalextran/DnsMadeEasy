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

	public function listDomains()
	{
		try
		{
			$domains = $this->_curl('domains');
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException('Unable to retrieve domain listing.', $e);
		}

		if (!$this->getRequestId()) {
 			throw new DnsMadeEasyException('Unable to retrieve domain listing. No request ID found.');
		}

		$domains = json_decode($domains, TRUE);

		if (!empty($domains['list'])) {
			$domains = $domains['list'];
		}

		return $domains;
	}

	public function deleteAllDomains()
	{
		try
		{
			$domains = $this->_curl('domains', DnsMadeEasyMethods::DELETE);
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException('Unable to delete all domains.', $e);
		}

		return $this->getRequestId() ? TRUE : FALSE;
	}

	public function getRequestLimit()
	{
		return empty($this->_headers['x-dnsme-requestLimit']) ? FALSE : (int) $this->_headers['x-dnsme-requestLimit'];
	}

	public function getRequestsRemaining()
	{
		return empty($this->_headers['x-dnsme-requestsRemaining']) ? FALSE : (int) $this->_headers['x-dnsme-requestsRemaining'];
	}

	public function getRequestId()
	{
		return empty($this->_headers['x-dnsme-requestId']) ? FALSE : $this->_headers['x-dnsme-requestId'];
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

	private function _curl($operation, $method = DnsMadeEasyMethods::GET)
	{
		if (empty($operation)) {
			throw new DnsMadeEasyException('The operation is required.');
		}

		$ch = curl_init();

		if (empty($ch)) {
			throw new DnsMadeEasyException('Unable to initialize a new cURL session.');
		}

		$requestDate = date('r');

		curl_setopt($ch, CURLOPT_URL, self::BASE_URL . 'domains');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, '_curlHeaderCallback'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"x-dnsme-apiKey: $this->_apiKey",
			"x-dnsme-requestDate: $requestDate",
			'x-dnsme-hmac: ' . $this->_hmac($requestDate),
		));

		$this->_headers = array();

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

		return $output;
	}
}

class DnsMadeEasyMethods
{
	const GET    = 'GET';
	const DELETE = 'DELETE';
	const PUT    = 'PUT';
}
?>
