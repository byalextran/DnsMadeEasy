<?php
require_once 'Exception.php';
require_once 'Base.php';
require_once 'Domains.php';
require_once 'Response.php';

class DnsMadeEasy
{
	public $domains;

	public function __construct($apiKey, $secretKey)
	{
		$this->domains = new DnsMadeEasy_Domains($apiKey, $secretKey);
	}

	/*
	public function getDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try {
			$apiResponse = $this->_curl("domains/$domain");
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to retrieve domain info for: $domain.", NULL, $e);
		}

		if ($apiResponse) {
			return new DnsMadeEasyDomain(json_decode($apiResponse, TRUE));
		}

		return FALSE;
	}

	public function getDomains()
	{
		try {
			$apiResponse = $this->_curl('domains');
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException('Unable to retrieve domain listing.', NULL, $e);
		}

		if ($apiResponse) {
			$domains = json_decode($apiResponse, TRUE);

			if (!empty($domains) && isset($domains['list'])) {
				$domains = $domains['list'];
			}
			else {
				$domains = array($apiResponse);
			}

			return $domains;
		}

		return FALSE;
	}

	public function deleteDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try {
			$apiResponse = $this->_curl("domains/$domain", 200, 404, DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to delete domain: $domain.", NULL, $e);
		}

		return $this->_httpStatusCode == 200;
	}

	public function deleteAllDomains()
	{
		try {
			$apiResponse = $this->_curl('domains', DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException('Unable to delete all domains.', NULL, $e);
		}

		return $this->_httpStatusCode == 200;
	}

	public function addDnsRecord($domain, $record)
	{
		// TODO: get working
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		if (empty($record)) {
			throw new DnsMadeEasyException('The record is required.');
		}

		try {
			$apiResponse = $this->_curl('domains/$domain/records', DnsMadeEasyMethod::POST, $record);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException(sprintf('Unable to add DNS record: %s (%s)', print_r($record, TRUE), $domain), NULL, $e);
		}

		if ($this->_httpStatusCode == 201) {
			return $this->requestId();
		}

		$this->_setErrors($apiResponse, 400);

		return FALSE;
	}


	public function getDnsRecord($domain, $recordId)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		if (empty($recordId)) {
			throw new DnsMadeEasyException('The record ID is required.');
		}

		try {
			$apiResponse = $this->_curl("domains/$domain/records/$recordId");
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to retrieve DNS record: $recordId ($domain).", NULL, $e);
		}

		if ($apiResponse) {
			return DnsMadeEasyBase::_getDnsRecord(json_decode($apiResponse, TRUE));
		}

		return FALSE;
	}

	public function getDnsRecords($domain, $type = NULL, $gtdLocation = NULL)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		$url = "domains/$domain/records?";

		if (!empty($type)) {
			$url .= "type=$type&";
		}

		if (!empty($gtdLocation)) {
			$url .= "gtdLocation=$gtdLocation&";
		}

		try {
			$apiResponse = $this->_curl($url);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to retrieve DNS records for: $domain.", NULL, $e);
		}

		if ($apiResponse) {
			return DnsMadeEasy::_getRecords(json_decode($apiResponse, TRUE));
		}

		return FALSE;
	}

	public function getSecondary()
	{
		try {
			$apiResponse = $this->_curl("secondary");
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to retrieve secondary entries.", NULL, $e);
		}

		if ($apiResponse) {
			$secondary = json_decode($apiResponse, TRUE);

			if (!empty($secondary) && isset($secondary['list'])) {
				$secondary = $secondary['list'];
			}
			else {
				$secondary = array($apiResponse);
			}

			return $secondary;
		}

		return FALSE;
	}

	public function deleteAllSecondary()
	{
		try {
			$apiResponse = $this->_curl('secondary', 200, 404, DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException('Unable to delete all secondary entries.', NULL, $e);
		}

		return $this->_httpStatusCode == 200;
	}

	protected static function _getRecords($recordsArray)
	{
		if (empty($recordsArray)) {
			return array();
		}

		$records = array();

		foreach($recordsArray as $record) {
			// TODO: i know there's a design pattern meant to address this...
			$records[] = DnsMadeEasyBase::_getDnsRecord($record);
		}

		return $records;
	}
	*/
}
?>
