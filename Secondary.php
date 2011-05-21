<?php
class DnsMadeEasy_Secondary extends DnsMadeEasy_Base
{
	const API_URL = 'secondary/';

	public function getAll()
	{
		try {
			$apiResponse = $this->_get(self::API_URL);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get secondary entries.", NULL, $e);
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
			throw new DnsMadeEasy_Exception("Unable to delete all secondary entries.", NULL, $e);
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
			throw new DnsMadeEasy_Exception("Unable to get secondary entry: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			// TODO: return secondary object
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
			throw new DnsMadeEasy_Exception("Unable to delete secondary entry: $domain.", NULL, $e);
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
			throw new DnsMadeEasy_Exception("Unable to add secondary entry: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 201) {
			// TODO: return a Domain object instead
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}
}
?>