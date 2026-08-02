<?php
/**
 * Model基础类
 * Date: 2024-02-20
 */

class BaseModel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
}