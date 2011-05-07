<?php
class DnsMadeEasyRecord
{
	protected $_id;
	protected $_name;
	protected $_type;
	protected $_data;
	protected $_ttl;
	protected $_gtdLocation;

	public function __construct($record)
	{
		if (empty($record)) {
			throw new DnsMadeEasyException('The record is required.');
		}

		$this->_id = empty($record['id']) ? -1 : (int) $record['id'];
		$this->_name = empty($record['name']) ? '' : $record['name'];
		$this->_type = empty($record['type']) ? '' : $record['type'];
		$this->_data = empty($record['data']) ? '' : $record['data'];
		$this->_ttl = empty($record['ttl']) ? -1 : (int) $record['ttl'];
		$this->_gtdLocation = empty($record['gtdLocation']) ? '' : $record['gtdLocation'];
	}

	public function id() { return $this->_id; }

	public function name() { return $this->_name; }

	public function type() { return $this->_type; }

	public function data() { return $this->_data; }

	public function ttl() { return $this->_ttl; }

	public function gtdLocation() { return $this->_gtdLocation; }
}
?>