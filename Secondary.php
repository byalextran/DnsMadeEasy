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
	 * @return DnsMadeEasy_Response
	 */
	public function getAll()
	{
		try {
			$apiResponse = $this->_get(self::API_URL, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get secondary entries.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Delete all secondary entries.
	 *
	 * @return DnsMadeEasy_Response
	 */
	public function deleteAll()
	{
		try {
			$apiResponse = $this->_delete(self::API_URL, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete all secondary entries.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Get information about a secondary entry.
	 *
	 * @param string $entry The entry to retrieve (e.g., <code>foobar.com</code>).
	 * @return DnsMadeEasy_Response
	 */
	public function get($entry)
	{
		try {
			$apiResponse = $this->_get(self::API_URL . $entry, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get secondary entry: $entry.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Delete a secondary entry.
	 *
	 * @param string $entry The entry to delete (e.g., <code>foobar.com</code>).
	 * @return DnsMadeEasy_Response
	 */
	public function delete($entry)
	{
		try {
			$apiResponse = $this->_delete(self::API_URL . $entry, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete secondary entry: $entry.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Add a secondary entry.
	 *
	 * @param string $entry The entry to add (e.g., <code>foobar.com</code>).
	 * @return DnsMadeEasy_Response
	 */
	public function add($entry)
	{
		try {
			$apiResponse = $this->_put(self::API_URL . $entry, 201);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add secondary entry: $entry.", NULL, $e);
		}

		return $apiResponse;
	}
}
?>