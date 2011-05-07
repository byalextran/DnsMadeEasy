<?php
class DnsMadeEasyBase
{
	protected $_apiKey;
	protected $_secretKey;
	protected $_testing;
	protected $_requestLimit;
	protected $_requestsRemaining;
	protected $_headers;
	protected $_httpStatusCode;
	protected $_errors;

	const BASE_URL = 'http://api.dnsmadeeasy.com/V1.2/';
	const BASE_TEST_URL = 'http://api.sandbox.dnsmadeeasy.com/V1.2/';

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
		$this->_errors = array();
	}

	public function httpStatusCode() { return $this->_httpStatusCode; }

	public function requestLimit() { return empty($this->_headers['x-dnsme-requestLimit']) ? FALSE : (int) $this->_headers['x-dnsme-requestLimit']; }

	public function requestsRemaining() { return empty($this->_headers['x-dnsme-requestsRemaining']) ? FALSE : (int) $this->_headers['x-dnsme-requestsRemaining']; }

	public function requestId() { return empty($this->_headers['x-dnsme-requestId']) ? FALSE : $this->_headers['x-dnsme-requestId']; }

	public function errors() { return $this->_errors; }

	protected function _hmac($requestDate)
	{
		if (empty($requestDate)) {
			throw new DnsMadeEasyException('The request date is required.');
		}

		return hash_hmac('sha1', $requestDate, $this->_secretKey);
	}

	protected function _curlHeaderCallback($ch, $header)
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

	protected function _curl($operation, $method = DnsMadeEasyMethod::GET, $post = NULL)
	{
		if (empty($operation)) {
			throw new DnsMadeEasyException('The operation is required.');
		}

		$ch = curl_init();

		if (empty($ch)) {
			throw new DnsMadeEasyException('Unable to initialize a new cURL session.');
		}

		$url = ($this->_testing ? self::BASE_TEST_URL : self::BASE_URL) . $operation;
		$requestDate = date('r');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, '_curlHeaderCallback'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"x-dnsme-apiKey: $this->_apiKey",
			"x-dnsme-requestDate: $requestDate",
			'x-dnsme-hmac: ' . $this->_hmac($requestDate),
		));

		if ($method == DnsMadeEasyMethod::POST && !empty($post)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		$this->_resetApiCallValues();

		$apiResponse = curl_exec($ch);

		if (($errno = curl_errno($ch)) > 0) {
		    throw new DnsMadeEasyException(curl_error($ch), $errno);
		}

		$this->_httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return $apiResponse;
	}

	protected function _resetApiCallValues()
	{
		$this->_headers = array();
		$this->_httpStatusCode = -1;
		$this->_errors = array();
	}

	protected function _setErrors($apiResponse, $httpErrorStatusCode = 404)
	{
		$errors = json_decode($apiResponse, TRUE);

		if ($this->_httpStatusCode == $httpErrorStatusCode && !empty($errors) && isset($errors['error'])) {
			$this->_errors = $errors['error'];
		}
		else {
			$this->_errors = array("HTTP Status Code: $httpErrorStatusCode, API Response: $apiResponse");
		}
	}
}

class DnsMadeEasyMethod
{
	const GET    = 'GET';
	const DELETE = 'DELETE';
	const PUT    = 'PUT';
	const POST    = 'POST';
}
?>
