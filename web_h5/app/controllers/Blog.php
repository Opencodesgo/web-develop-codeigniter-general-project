<?php

class Blog extends CI_Controller {
	
	public function index() {
		echo 'Hello World!';
		
		echo '<pre>';
		debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	}
	
	public function comments() {
		echo 'Look at this!';
	}
	
}