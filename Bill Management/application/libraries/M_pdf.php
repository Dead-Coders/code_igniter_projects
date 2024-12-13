
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/mpdf/mpdf.php';
// require_once dirname(__FILE__) . '/mpdf/mpdf.php';
class M_pdf extends mpdf 
{
 
	// public $param;
	// public $pdf;
	// public function __construct($param = "'c', 'A4-L'")
	// {
	//     $this->param =$param;
	//     $this->pdf = new mPDF($this->param);
	// }
	function __construct()
    {
        parent::__construct();
    }
}