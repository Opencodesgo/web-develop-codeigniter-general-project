<?php
/**
 * Demo02 数据库
 */

class BaseController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('BaseModel');
	}

}