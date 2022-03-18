<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : Muhammad Surya Ikhsanudin 
 *  License    : Protected 
 *  Email      : mutofiyah@gmail.com 
 *   
 *  Dilarang merubah, mengganti dan mendistribusikan 
 *  ulang tanpa sepengetahuan Author 
 *  ======================================= 
 */  
require_once APPPATH."libraries/PHPExcel/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
	
	public function excel_save($filename){		
        $objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel2007');  
        ob_end_clean();
		
		$path = $_SERVER['DOCUMENT_ROOT'];
        $objWriter->save($path.'/temp/'.$filename);
    }
}