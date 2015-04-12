<?php
/**
 * Provides base functionality required for all DNS Made Easy API calls.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy_BaseV2
{
	protected $_apiKey;
	protected $_secretKey;
	protected $_headers;
	protected $_test;

    const API_BASE_URL = 'http://api.dnsmadeeasy.com/V2.0/';
    const API_BASE_URL_TEST = 'http://api.sandbox.dnsmadeeasy.com/V2.0/';

	public function __construct($apiKey, $secretKey, $test = FALSE)
	{
		$this->_apiKey = $apiKey;
		$this->_secretKey = $secretKey;
		$this->_test = $test;
	}

	protected function _get($operation, $successCode)
	{
		return $this->_curl($operation, 'GET', $successCode);
	}

	protected function _delete($operation, $successCode)
	{
		return $this->_curl($operation, 'DELETE', $successCode);
	}

	protected function _put($operation, $data, $successCode)
	{
		return $this->_curl($operation, 'PUT', $successCode, $data);
	}

	protected function _post($operation, $data, $successCode)
	{
		return $this->_curl($operation, 'POST', $successCode, $data);
	}

	private function _curl($operation, $method, $successCode, $postData = NULL)
	{
		$url = ($this->_test ? self::API_BASE_URL_TEST : self::API_BASE_URL) . $operation;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, '_headerCallback'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_requestHeaders());

		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
		}
		else if ($method == 'PUT') {
			curl_setopt($ch, CURLOPT_HTTPHEADER,  // Ask the remote end to PUT, curl won't PUT a raw body
				    array_merge(array('X-HTTP-Method-Override: PUT'), $this->_requestHeaders()));
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
		}

		// reset the header values
		$this->_headers = array();

		$apiResponse = curl_exec($ch);

		if (($errno = curl_errno($ch)) > 0) {
		    throw new DnsMadeEasy_Exception(sprintf('CURL ERROR: %s - URL: %s', curl_error($ch), $url), $errno);
		}

		$ci = curl_getinfo($ch);

		curl_close($ch);

		return new DnsMadeEasy_Response($apiResponse, $ci, $this->_headers, $successCode);
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
		$requestDate = gmdate('r');

		return array(
			"x-dnsme-apiKey: $this->_apiKey",
			"x-dnsme-requestDate: $requestDate",
			"x-dnsme-hmac: " . $this->_hash($requestDate),
			'Content-Type: application/json',
		);
	}

	protected function _hash($requestDate)
	{
		return hash_hmac('sha1', $requestDate, $this->_secretKey);
	}
}
?>
