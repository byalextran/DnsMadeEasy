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

	public function getName() { return $this->_name; }

	public function setName($name) { $this->_name = $name; }

	public function getType() { return $this->_type; }

	public function setType($type) { $this->_type = $type; }

	public function getData() { return $this->_data; }

	public function setData($data) { $this->_data = $data; }

	public function getTtl() { return $this->_ttl; }

	public function setTtl($ttl) { $this->_ttl = $ttl; }

	public function getGtdLocation() { return $this->_gtdLocation; }

	public function setGtdLocation($gtdLocation) { $this->_gtdLocation = $gtdLocation; }
}
?>