<?php
//defined('BASEPATH') or exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once 'dompdf-master/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Adapter\CPDF;
use Dompdf\Exception;


class Pdfgenerator
{
    public function generate($html, $filename, $paper, $orientation, $x, $y, $text, $size, $file_path, $stream = TRUE)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->setChroot(FCPATH);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        // //testing
        // $options = new Options();
        // $options->set('isRemoteEnabled', TRUE);
        // $options->setChroot(FCPATH);

        // $_HTML = '<img src="'.FCPATH.'assets/QR/'.'2c6fe05d59b582bc39525b8ff48a5c64.jpg">';
        // echo $_HTML;
        // $pdf = new Dompdf();
        // $pdf->loadHtml($_HTML);
        // $pdf->setPaper('A4', 'portrait');
        // $pdf->render();
        // //$pdf->stream("", array("Attachment" => false));
        // if ($stream) {
        //     //$dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        //     file_put_contents($file_path . $filename . '.pdf', $pdf->output());
        // } else {
        //     return $pdf->output();
        // }

        // Parameter
        $font = $dompdf->getFontMetrics()->get_font('Calibri Light', 'normal');
        $dompdf->getCanvas()->page_text(
            $x,
            $y,
            $text,
            $font,
            $size
        );

        if ($stream) {
            //$dompdf->stream($filename . ".pdf", array("Attachment" => 0));
            file_put_contents($file_path . $filename . '.pdf', $dompdf->output());
        } else {
            return $dompdf->output();
        }
    }
}
