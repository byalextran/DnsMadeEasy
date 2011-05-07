<?php
class DnsMadeEasyMxRecord extends DnsMadeEasyRecord
{
	protected $_priority;
	protected $_targetName;

	public function __construct($record)
	{
		parent::__construct($record);

		$this->_priority = -1;
		$this->_targetName = '';

		echo $record;

		if (preg_match('/(?<priority>\d+)\s*(?<targetName>.+)/', $this->_data, $matches) > 0) {
			$this->_priority = (int) $matches['priority'];
			$this->_targetName = $matches['targetName'];
		}
	}

	public function priority() { return $this->_priority; }

	public function targetName() { return $this->_targetName; }
}
?>