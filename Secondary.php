<?php
/**
 * Provides access to secondary-related API calls.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy_Secondary extends DnsMadeEasy_Base
{
	const API_URL = 'secondary/';

	/**
	 * Get list of all secondary entries.
	 *
	 * @return array|DnsMadeEasy_Response Returns an associative array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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

	/**
	 * Delete all secondary entries.
	 *
	 * @return TRUE|DnsMadeEasy_Response Returns TRUE if successful or a DnsMadeEasy_Response object if the call failed.
	 */
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

	/**
	 * Get information about a secondary entry.
	 *
	 * @param string $entry The entry to retrieve (e.g., <code>foobar.com</code>).
	 * @return array|DnsMadeEasy_Response Returns an associative array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
	public function get($entry)
	{
		try {
			$apiResponse = $this->_get(self::API_URL . $entry);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get secondary entry: $entry.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			// TODO: return secondary object.
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}

	/**
	 * Delete a secondary entry.
	 *
	 * @param string $entry The entry to delete (e.g., <code>foobar.com</code>).
	 * @return TRUE|DnsMadeEasy_Response Returns TRUE if successful or a DnsMadeEasy_Response object if the call failed.
	 */
	public function delete($entry)
	{
		try {
			$apiResponse = $this->_delete(self::API_URL . $entry);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete secondary entry: $entry.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 200) {
			return TRUE;
		}

		return $apiResponse;
	}

	/**
	 * Add a secondary entry.
	 *
	 * @param string $entry The entry to add (e.g., <code>foobar.com</code>).
	 * @return array|DnsMadeEasy_Response Returns an associative array if successful or a DnsMadeEasy_Response object if the call failed.
	 */
	public function add($entry)
	{
		try {
			$apiResponse = $this->_put(self::API_URL . $entry);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add secondary entry: $entry.", NULL, $e);
		}

		if ($apiResponse->httpStatusCode() == 201) {
			// TODO: return a Domain object instead
			return json_decode($apiResponse->body(), TRUE);
		}

		return $apiResponse;
	}
}
?>