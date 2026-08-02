<?php
/**
 * Demo03 读写文件
 */

class Demo03 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('file');
	}
	
	//http://localhost:8102/demo03
	public function index() {		
		echo 'This is Demo03';
	}
	
	/**
	 * http://localhost:8102/demo03/gettxt
	 * 场景1：读写TXT文本
	 */
	public function gettxt() {
		$content = 'a2';
		$file = '../data/11.txt';
		$ret = write_file($file,$content);
		$content2 = read_file($file);
		var_dump($content2);
	}
	
	/**
	 * http://localhost:8102/demo03/getpdf
	 * 场景1：读取PDF
	 */
	public function getpdf() {
		//$file = '../data/11.pdf';
		//$content = read_file($file);
		$this->load->library('fpdf');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Hello World!');
		$pdf->Output();	
		var_dump($pdf);
	}

}