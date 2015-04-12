<?php
/**
 * Provides access to record-related API calls.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy_RecordsV2 extends DnsMadeEasy_BaseV2
{
	const API_URL = 'records';

	/**
	 * Get list of all DNS records for a domain.
	 *
	 * @param string $domainId The domainId to retrieve records for (e.g., <code>3214567</code>).
	 * @param string $type Filter records by type (e.g., A, CNAME, MX).
	 * @return DnsMadeEasy_Response
	 */
	public function getAll($domainId, $type = NULL)
	{
		$url = DnsMadeEasy_DomainsV2::API_URL . '/' . $domainId . '/' . self::API_URL . '?';

		if (!empty($type)) {
			$url .= "type=$type&";
		}

// TODO: Handle number of rows / paging (part of the API)
//        if (!empty($rows)) {
//            $url .= "rows=$rows&";
//        }
//
//        if (!empty($page)) {
//            $url .= "page=$page&";
//        }

        try {
			$apiResponse = $this->_get($url, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to get records for domain Id: $domainId.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Add a DNS record.
	 *
     * @param string $domainId The domainId to retrieve records for (e.g., <code>3214567</code>).
	 * @param array $record An associative array representing the record to add.
	 * @return DnsMadeEasy_Response
	 */
	public function add($domainId, $record)
	{
		$url = DnsMadeEasy_DomainsV2::API_URL . '/' . $domainId . '/' . self::API_URL;

		try {
			$apiResponse = $this->_post($url, $record, 201);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to add record: $record ($domain).", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Delete a specific DNS record for a domain.
	 *
     * @param string $domainId The domainId to retrieve records for (e.g., <code>3214567</code>).
	 * @param int $recordId The record ID to delete.
	 * @return DnsMadeEasy_Response
	 */
	public function delete($domainId, $recordId)
	{
		$url = DnsMadeEasy_DomainsV2::API_URL . '/' . $domainId . '/' . self::API_URL . '/' . $recordId . '/';

		try {
			$apiResponse = $this->_delete($url, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to delete record $recordId from domain Id $domainId.", NULL, $e);
		}

		return $apiResponse;
	}

	/**
	 * Update an existing DNS record for a domain.
	 *
     * @param string $domainId The domainId to retrieve records for (e.g., <code>3214567</code>).
	 * @param int $recordId The record ID to update.
	 * @param array $record An associative array representing the record to update.
	 * @return DnsMadeEasy_Response
	 */
	public function update($domainId, $recordId, $record)
	{
		$url = DnsMadeEasy_DomainsV2::API_URL . '/' . $domainId . '/' . self::API_URL . '/'. $recordId . '/';

		try {
			$apiResponse = $this->_put($url, $record, 200);
		}
		catch (Exception $e) {
			throw new DnsMadeEasy_Exception("Unable to update record $recordId in domain Id $domainId.", NULL, $e);
		}

		return $apiResponse;
	}
}
?>
