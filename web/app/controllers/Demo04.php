<?php
/**
 * Demo04 缓存
 */

class Demo04 extends CI_Controller {
	
	//http://localhost:8102/demo04
	public function index() {		
		echo 'This is Demo04';
		$this->output->cache(1);
	}
	
	//http://localhost:8102/demo04/setcache
	public function setcache() {		
		echo 'set cache';
		$this->output->cache(1);
	}
	
	//http://localhost:8102/demo04/deletecache
	public function deletecache() {		
		echo 'delete cache';
		$this->output->delete_cache('/demo04/setcache');
	}

}