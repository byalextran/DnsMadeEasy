<?php
require_once 'Exception.php';
require_once 'Base.php';
require_once 'Response.php';
require_once 'Domains.php';
require_once 'Records.php';
require_once 'Secondary.php';

// TODO: phpdoc-ify
// TODO: unit tests

class DnsMadeEasy
{
	public $domains;
	public $records;
	public $secondary;

	public function __construct($apiKey, $secretKey, $test)
	{
		$this->domains = new DnsMadeEasy_Domains($apiKey, $secretKey, $test);
		$this->records = new DnsMadeEasy_Records($apiKey, $secretKey, $test);
		$this->secondary = new DnsMadeEasy_Secondary($apiKey, $secretKey, $test);
	}
}
?>
