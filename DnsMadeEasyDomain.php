<?php
class DnsMadeEasyDomain
{
	protected $_name;
	protected $_nameServers;
	protected $_gtdEnabled;

	public function __construct($domain)
	{
		if (empty($domain)) {
			throw new DnsMadeEasyException('The domain is required.');
		}

		$this->_name = empty($domain['name']) ? '' : $domain['name'];
		$this->_nameServers = empty($domain['nameServer']) ? array() : $domain['nameServer'];
		$this->_gtdEnabled = empty($domain['gtdEnabled']) ? FALSE : (bool) $domain['gtdEnabled'];
	}

	public function name() { return $this->_name; }

	public function nameServers() { return $this->_nameServers; }

	public function gtdEnabled() { return $this->_gtdEnabled; }
}
?>