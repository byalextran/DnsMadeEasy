<?php
require_once 'DnsMadeEasyBase.php';
require_once 'DnsMadeEasyDomain.php';

class DnsMadeEasy extends DnsMadeEasyBase
{
	public function getDomains()
	{
		try {
			$output = $this->_curl('domains');
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException('Unable to retrieve domain listing.', NULL, $e);
		}

		if ($this->_httpResponseCode == 200) {
			$domains = json_decode($output, TRUE);

			if (!empty($domains) && isset($domains['list'])) {
				$domains = $domains['list'];
			}
			else {
				$domains = array($output);
			}

			return $domains;
		}

		$this->_errors = array($output);

		return FALSE;
	}

	public function deleteAllDomains()
	{
		try {
			$output = $this->_curl('domains', DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException('Unable to delete all domains.', NULL, $e);
		}

		if ($this->_httpResponseCode == 200) {
			return TRUE;
		}

		$this->_errors = array($output);

		return FALSE;
	}

	public function getDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try {
			$output = $this->_curl("domains/$domain");
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to retrieve domain info for: $domain.", NULL, $e);
		}

		if ($this->_httpResponseCode == 200) {
			return new DnsMadeEasyDomain(json_decode($info, TRUE));
		}

		$this->_setErrors($output);

		return FALSE;
	}

	public function deleteDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try {
			$output = $this->_curl("domains/$domain", DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to delete domain: $domain.", NULL, $e);
		}

		if ($this->_httpResponseCode == 200) {
			return TRUE;
		}

		$this->_setErrors($output);

		// API doesn't return an error message if domain doesn't exist, so manually add one.
		if ($this->_httpResponseCode == 404) {
			$this->_errors = array("Unable to delete domain: $domain. Domain not found.");
		}

		return FALSE;
	}

	public function addDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try {
			$output = $this->_curl("domains/$domain", DnsMadeEasyMethod::PUT);
		}
		catch (Exception $e) {
			throw new DnsMadeEasyException("Unable to add domain: $domain.", NULL, $e);
		}

		if ($this->_httpResponseCode == 201) {
			return new DnsMadeEasyDomain(json_decode($output, TRUE));
		}

		$this->_setErrors($output, 400);

		return FALSE;
	}
}
?>
