<?php
class DnsMadeEasy_Records extends DnsMadeEasy_Base
{
	const API_URL = 'records/';

	public function getAll($domain, $gtdLocation = NULL, $type = NULL)
	{
		$url = DnsMadeEasy_Domains::API_URL . $domain . '/' . self::API_URL . '?';

		if (!empty($gtdLocation)) {
			$url .= "gtdLocation=$gtdLocation&";
		}

		if (!empty($type)) {
			$url .= "type=$type&";
		}

		try {
			$apiResponse = $this->_get($url);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get records for domain: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			// TODO: return record objects.
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	public function get($domain, $recordId)
	{
		$url = DnsMadeEasy_Domains::API_URL . $domain . '/' . self::API_URL . $recordId;

		try {
			$apiResponse = $this->_get($url);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get records for domain: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			// TODO: return record objects.
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	public function add($domain, $record)
	{
		// TODO: get this function working.
		$url = DnsMadeEasy_Domains::API_URL . $domain . '/' . self::API_URL;

		try {
			$apiResponse = $this->_post($url, $record);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add record: $record ($domain).", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 201) {
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	public function delete($domain, $recordId)
	{
		$url = DnsMadeEasy_Domains::API_URL . $domain . '/' . self::API_URL . $recordId;

		try {
			$apiResponse = $this->_delete($url);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete record $recordId from $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			return TRUE;
		}

		return $apiResponse;
	}
}
?>