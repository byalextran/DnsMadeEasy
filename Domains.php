<?php
/**
 * Provides access to domain-related API calls.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy_Domains extends DnsMadeEasy_Base
{
	const API_URL = 'domains/';

	/**
	 * Get list of all domain names.
	 *
	 * @return array|DnsMadeEasy_Response Returns an array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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

	/**
	 * Delete all domains.
	 *
	 * @return TRUE|DnsMadeEasy_Response Returns TRUE if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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

	/**
	 * Get information about a domain.
	 *
	 * @param string $domain The domain to retrieve (e.g., <code>foobar.com</code>).
	 * @return array|DnsMadeEasy_Response Returns an associative array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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

	/**
	 * Delete a domain.
	 *
	 * @param string $domain The domain to delete (e.g., <code>foobar.com</code>).
	 * @return TRUE|DnsMadeEasy_Response Returns TRUE if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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

	/**
	 * Add a domain.
	 *
	 * @param string $domain The domain to add (e.g., <code>foobar.com</code>).
	 * @return array|DnsMadeEasy_Response Returns an associative array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
	public function add($domain)
	{
		try {
			$apiResponse = $this->_put(self::API_URL . $domain);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add domain: $domain.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 201) {
			// TODO: return domain object.
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}
}
?>