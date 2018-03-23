<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."./third_party/vendor/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

class PDFGenerator
{
    public function create($html, $filename='', $stream = true, $paper = 'A4', $orientation = 'portrait')
    {
        $dompdf = new DOMPDF();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if($stream) 
        {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        }
        else 
        {
            return $dompdf->output();
        }
    }
}