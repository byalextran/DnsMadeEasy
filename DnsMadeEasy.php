<?php
require_once 'DnsMadeEasyBase.php';
require_once 'DnsMadeEasyDomain.php';

class DnsMadeEasy extends DnsMadeEasyBase
{
	public function listDomains()
	{
		try
		{
			$domains = $this->_curl('domains');
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException('Unable to retrieve domain listing.', NULL, $e);
		}

		if (!$this->getRequestId()) {
 			throw new DnsMadeEasyException('Unable to retrieve domain listing. No request ID found.');
		}

		$domains = json_decode($domains, TRUE);

		if (!empty($domains['list'])) {
			$domains = $domains['list'];
		}

		return $domains;
	}

	public function deleteAllDomains()
	{
		try
		{
			$this->_curl('domains', DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException('Unable to delete all domains.', NULL, $e);
		}

		return $this->getRequestId() ? TRUE : FALSE;
	}

	public function getDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try
		{
			$info = $this->_curl("domains/$domain");
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException("Unable to retrieve domain info for: $domain.", NULL, $e);
		}

		return new DnsMadeEasyDomain(json_decode($info, TRUE));
	}

	public function deleteDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try
		{
			$this->_curl("domains/$domain", DnsMadeEasyMethod::DELETE);
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException("Unable to delete domain: $domain.", NULL, $e);
		}

		return $this->getRequestId() ? TRUE : FALSE;
	}

	public function addDomain($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		try
		{
			$output = $this->_curl("domains/$domain", DnsMadeEasyMethod::PUT);
		}
		catch (Exception $e)
		{
			throw new DnsMadeEasyException("Unable to add domain: $domain.", NULL, $e);
		}

		return new DnsMadeEasyDomain(json_decode($output, TRUE));
	}
}
?>
