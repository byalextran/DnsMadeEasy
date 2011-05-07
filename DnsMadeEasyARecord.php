<?php
class DnsMadeEasyARecord extends DnsMadeEasyRecordBase
{
	protected $_password;

	public function __construct($record)
	{
		parent::__construct($record);

		$this->_password = empty($record['password']) ? '' : $record['password'];
	}

	public function hostIp() { return $this->_data; }

	public function password() { return $this->_password; }
}
?>