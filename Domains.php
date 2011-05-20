<?php
class DnsMadeEasy_Domains extends DnsMadeEasy_Base
{
	const API_URL = 'domains/';

	public function getAll()
	{
		try {
			$apiResponse = $this->_get(self::API_URL);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception('Unable to get domain listing.', NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	public function deleteAll()
	{
		try {
			$apiResponse = $this->_delete(self::API_URL);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception('Unable to delete all domains.', NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			return TRUE;
		}

		return $apiResponse;
	}

	public function get($domain)
	{
		try {
			$apiResponse = $this->_get(self::API_URL . $domain);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get domain: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	public function delete($domain)
	{
		try {
			$apiResponse = $this->_delete(self::API_URL . $domain);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete domain: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			return TRUE;
		}

		return $apiResponse;
	}

	public function add($domain)
	{
		try {
			$apiResponse = $this->_put(self::API_URL . $domain);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add domain: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 201) {
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}
}
?>