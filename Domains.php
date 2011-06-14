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
	 * @return DnsMadeEasy_Response
	 */
	public function getAll()
	{
		try {
			$apiResponse = $this->_get(self::API_URL, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception('Unable to get domain listing.', NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Delete all domains.
	 *
	 * @return DnsMadeEasy_Response
	 */
	public function deleteAll()
	{
		try {
			$apiResponse = $this->_delete(self::API_URL, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception('Unable to delete all domains.', NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Get information about a domain.
	 *
	 * @param string $domain The domain to retrieve (e.g., <code>foobar.com</code>).
	 * @return DnsMadeEasy_Response
	 */
	public function get($domain)
	{
		try {
			$apiResponse = $this->_get(self::API_URL . $domain, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get domain: $domain.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Delete a domain.
	 *
	 * @param string $domain The domain to delete (e.g., <code>foobar.com</code>).
	 * @return DnsMadeEasy_Response
	 */
	public function delete($domain)
	{
		try {
			$apiResponse = $this->_delete(self::API_URL . $domain, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete domain: $domain.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Add a domain.
	 *
	 * @param string $domain The domain to add (e.g., <code>foobar.com</code>).
	 * @return DnsMadeEasy_Response
	 */
	public function add($domain)
	{
		try {
			$apiResponse = $this->_put(self::API_URL . $domain, 201);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add domain: $domain.", NULL, $e);
		}

		return $apiResponse;
	}
}
?>