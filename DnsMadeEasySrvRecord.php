<?php
class DnsMadeEasySrvRecord extends DnsMadeEasyRecord
{
	protected $_priority;
	protected $_weight;
	protected $_port;
	protected $_targetName;

	public function __construct($record)
	{
		parent::__construct($record);

		$this->_priority = '';
		$this->_weight = '';
		$this->_port = '';
		$this->_targetName = '';

		if (preg_match('/(?<priority>\d+)\s*(?<weight>\d+)\s*(?<port>\d+)\s*(?<targetName>.+)/', $this->_data, $matches) > 0) {
			$this->_priority = (int) $matches['priority'];
			$this->_weight = (int) $matches['weight'];
			$this->_port = (int) $matches['port'];
			$this->_targetName = $matches['targetName'];
		}
	}

	public function priority() { return $this->_priority; }

	public function weight() { return $this->_weight; }

	public function port() { return $this->_port; }

	public function targetName() { return $this->_targetName; }
}
?>