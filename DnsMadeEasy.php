<?php
require_once 'Exception.php';
require_once 'Base.php';
require_once 'Response.php';
require_once 'Domains.php';
require_once 'Records.php';
require_once 'Secondary.php';

/**
 * The main class used to access the DNS Made Easy API.
 *
 * Please review the DNS Made Easy <a href="http://www.dnsmadeeasy.com/enterprisedns/api.html">API documentation</a> for more information.
 *
 * @package DnsMadeEasy
 */
class DnsMadeEasy
{
	/**
	 * Used to access domain-related API calls.
	 *
	 * @returns DnsMadeEasy_Domains
	 */
	public $domains;

	/**
	 * Used to access record-related API calls.
	 *
	 * @returns DnsMadeEasy_Records
	 */
	public $records;

	/**
	 * Used to access secondary-related API calls.
	 *
	 * @returns DnsMadeEasy_Secondary
	 */
	public $secondary;

	/**
	 * @param string $apiKey The API key from your DNS Made Easy account.
	 * @param string $secretKey The secret key from your DNS Made Easy account.
	 * @param bool $test Set to TRUE if you want to make test API calls.
	 */
	public function __construct($apiKey, $secretKey, $test = FALSE)
	{
		$this->domains = new DnsMadeEasy_Domains($apiKey, $secretKey, $test);
		$this->records = new DnsMadeEasy_Records($apiKey, $secretKey, $test);
		$this->secondary = new DnsMadeEasy_Secondary($apiKey, $secretKey, $test);
	}
}
?>
