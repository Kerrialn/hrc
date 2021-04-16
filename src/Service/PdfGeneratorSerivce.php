<?php

namespace App\Service;

use Dompdf\Dompdf;

final class PdfGeneratorSerivce
{

  public function generatePdfFromHtml($html)
  {
    $pdf = new Dompdf();
    $pdf->setPaper('A4', 'portrait');
    $pdf->loadHtml($html);
    $pdf->render();

    return $pdf->stream();
  }
}