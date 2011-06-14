<?php
/**
 * Provides access to record-related API calls.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy_Records extends DnsMadeEasy_Base
{
	const API_URL = 'records/';

	/**
	 * Get list of all DNS records for a domain.
	 *
	 * @param string $domain The domain to retrieve records for (e.g., <code>foobar.com</code>).
	 * @param string $gtdLocation Filter records by location.
	 * @param string $type Filter records by type (e.g., A, CNAME, MX).
	 * @return array|DnsMadeEasy_Response Returns an array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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
			// TODO: return array of record objects.
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	/**
	 * Get a specific DNS record for a domain.
	 *
	 * @param string $domain The domain to retrieve a record for (e.g., <code>foobar.com</code>).
	 * @param int $recordId The record ID to retrieve.
	 * @return array|DnsMadeEasy_Response Returns an associative if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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
			// TODO: return record object.
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	/**
	 * Add a DNS record.
	 *
	 * @param string $domain The domain to add a record to (e.g., <code>foobar.com</code>).
	 * @param array $record An associative array representing the record to add.
	 * @return array|DnsMadeEasy_Response Returns an associative array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
	public function add($domain, $record)
	{
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

	/**
	 * Delete a specific DNS record for a domain.
	 *
	 * @param string $domain The domain to delete a record for (e.g., <code>foobar.com</code>).
	 * @param int $recordId The record ID to delete.
	 * @return TRUE|DnsMadeEasy_Response Returns TRUE if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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