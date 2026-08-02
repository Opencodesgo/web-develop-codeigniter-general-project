<?php

class Test extends CI_Controller {
	
	//http://localhost:8102/index.php?c=test&m=index
	//http://localhost:8102/test/comments
	public function index() {		
		echo '<pre>';
		debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	}
	
	public function comments() {
		echo 'Look at this!';
	}
	
}