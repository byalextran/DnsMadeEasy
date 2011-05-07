<?php
class DnsMadeEasyHttpRedirectRecord extends DnsMadeEasyRecordBase
{
	protected $_description;
	protected $_keywords;
	protected $_title;
	protected $_redirectType;
	protected $_hardLink;

	public function __construct($record)
	{
		parent::__construct($record);

		$this->_description = empty($record['description']) ? '' : $record['description'];
		$this->_keywords = empty($record['keywords']) ? '' : $record['keywords'];
		$this->_title = empty($record['title']) ? '' : $record['title'];
		$this->_redirectType = empty($record['redirectType']) ? '' : $record['redirectType'];
		$this->_hardLink = empty($record['hardLink']) ? FALSE : (bool) $record['hardLink'];
	}

	public function description() { return $this->_description; }

	public function keywords() { return $this->_keywords; }

	public function title() { return $this->_title; }

	public function redirectType() { return $this->_redirectType; }

	public function hardLink() { return $this->_hardLink; }
}
?>