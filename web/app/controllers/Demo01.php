<?php
/**
 * Demo01 通用
 * CodeIgniter 是一个动态实例化，高度组件专一性的松耦合系统。它在小巧的基础上力求做到 简单、灵活和高性
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
	
	//http://localhost:8102/demo01/test02
	public function test02() {
		$server = $_SERVER;

		echo '<pre>';
		var_dump($server);exit;		
	}

}