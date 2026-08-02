<?php
/**
 * Demo02 数据库
 */

class Demo02 extends CI_Controller {
	
	//http://localhost:8102/demo02
	public function index() {		
		echo 'This is Demo02';
	}
	
	/**
	 * http://localhost:8102/demo02/getdata
	 * 场景1：读取数据
	 */
	public function getdata() {
		//echo '<pre>';
		$this->load->model('sale');
		$data = $this->sale->getRow();
	}
	
	/**
	 * http://localhost:8102/demo02/gettables
	 * 场景2：获取数据表清单
	 */
	public function gettables() {
		$tables = $this->db->list_tables();
		var_dump($tables);
	}

}