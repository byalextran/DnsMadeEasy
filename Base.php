<?php
class DnsMadeEasy_Base
{
	protected $_apiKey;
	protected $_secretKey;
	protected $_headers;

	const API_BASE_URL = 'http://api.sandbox.dnsmadeeasy.com/V1.2/';

	public function __construct($apiKey, $secretKey)
	{
		// needed for date() functions
		date_default_timezone_set('UTC');

		$this->_apiKey = $apiKey;
		$this->_secretKey = $secretKey;
		$this->_headers = array();
	}

	protected function _get($operation)
	{
		return $this->_curl($operation);
	}

	protected function _delete($operation)
	{
		return $this->_curl($operation, 'DELETE');
	}

	protected function _put($operation)
	{
		return $this->_curl($operation, 'PUT');
	}

	private function _curl($operation, $method = 'GET')
	{
		$url = self::API_BASE_URL . $operation;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, '_headerCallback'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_requestHeaders());

		// reset the header values
		$this->_headers = array();

		$apiResponse = curl_exec($ch);

		if (($errno = curl_errno($ch)) > 0) {
		    throw new DnsMadeEasy_Exception(sprintf('CURL ERROR: %s - URL: %s', curl_error($ch), $url), $errno);
		}

		$ci = curl_getinfo($ch);

		curl_close($ch);

		return new DnsMadeEasy_Response($apiResponse, $ci, $this->_headers);
	}

	protected function _headerCallback($ch, $header)
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

	protected function _requestHeaders()
	{
		$requestDate = date('r');

		return array(
			"x-dnsme-apiKey: $this->_apiKey",
			"x-dnsme-requestDate: $requestDate",
			"x-dnsme-hmac: " . $this->_hash($requestDate),
		);
	}

	protected function _hash($requestDate)
	{
		return hash_hmac('sha1', $requestDate, $this->_secretKey);
	}
}
?>
