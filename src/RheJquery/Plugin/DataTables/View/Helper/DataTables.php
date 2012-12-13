<?php
/**
 * @author Robert Hennig <info@robcoding.de>
 * @copyright Copyright (c) 2012 Robert Hennig <info@robcoding.de>
 */
namespace RheJquery\Plugin\DataTables\View\Helper;

use Zend\View\Helper\AbstractHelper;
use RheJquery\Plugin\DataTables\DataTable;

/**
 * DataTables view helper.
 *
 * The helper provides methods to create the necessary HTML and JavaScript code
 * to display the specified table.
 *
 * @author Robert Hennig <info@robcoding.de>
 * @copyright Copyright (c) 2012 Robert Hennig <info@robcoding.de>
 */
class DataTables extends AbstractHelper {
	/**
	 * The DataTable instance containing the configuration.
	 * 
	 * @var DataTable
	 */
	private $_dataTable;
	
	/**
	 * Get the underlying DataTable instance.
	 * 
	 * @return DataTable
	 */
	public function getDataTable() {
		return $this->_dataTable;
	}
	
	/**
	 * Set the underlying DataTable instance.
	 * 
	 * @param DataTable $dataTable
	 */
	public function setDataTable(DataTable $dataTable) {
		$this->_dataTable = $dataTable;
	}
	
	
}