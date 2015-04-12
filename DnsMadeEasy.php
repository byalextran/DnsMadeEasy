<?php
require_once 'Exception.php';
require_once 'Response.php';

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
     * Used to define API version to use
     *
     * @returns DnsMadeEasy_Secondary
     */
    public $version;

    /**
	 * @param string $apiKey The API key from your DNS Made Easy account.
	 * @param string $secretKey The secret key from your DNS Made Easy account.
	 * @param bool $test Set to TRUE if you want to make test API calls.
     * @param integer $version Can be 1 or 2 (default is 1).  2 uses the new V2.0 API
	 */
	public function __construct($apiKey, $secretKey, $test = FALSE, $version=1)
	{
        if($version == 1) { // v1.2 of the API
            require_once 'Base.php';
            require_once 'Domains.php';
            require_once 'Records.php';
            require_once 'Secondary.php';

            $this->domains = new DnsMadeEasy_Domains($apiKey, $secretKey, $test);
            $this->records = new DnsMadeEasy_Records($apiKey, $secretKey, $test);
            $this->secondary = new DnsMadeEasy_Secondary($apiKey, $secretKey, $test);
        }
        else { // v2 of the API
            require_once 'BaseV2.php';
            require_once 'DomainsV2.php';
            require_once 'RecordsV2.php';

            $this->records = new DnsMadeEasy_RecordsV2($apiKey, $secretKey, $test);
        }
	}
}
?>
