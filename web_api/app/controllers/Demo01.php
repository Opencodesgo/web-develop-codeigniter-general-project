<?php
/**
 * Demo01 通用
 */

class Demo01 extends CI_Controller {
	
	//http://localhost:8102/demo01
	public function index() {		
		echo 'This is Demo01';
	}
	
	public function testlog() {
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');
		$cache_path = ($path === '') ? APPPATH.'cache/' : $path;
		
		//var_dump($cache_path);
		log_message('error', 'Test cache file');
	}
	
	
	//http://localhost:8102/demo01/test
	public function test() {
		$this->load->view('templates/header');
		$this->load->view('templates/footer');
	}

}