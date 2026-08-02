<?php
/**
 * Sale模型
 * Date: 2024-02-20
 */

class Sale extends BaseModel {
	
	private $_tablename = 'sales';
	
	public function getRow() {
		$query = $this->db->query('select * from '.$this->_tablename);
		$data = $query->result_array();
		var_dump($data);
	}
	
}