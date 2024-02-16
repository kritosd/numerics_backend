<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;


class PDFController extends Controller
{
    public function generateHtmlToPDF(Request $request) {

        $html_url = $request->input('html_url');

        $url = $this->generateImage($html_url);

        return json_encode(array('url'=> $url));
    }

    public function generateImage($html_url)
    {

        // GENERATE PDF FROM HTML
        $html = file_get_contents($html_url);
        
        // change font familyt to display greek lang.
        $html = '<style> body { font-family: DejaVu Sans, sans-serif; } </style>' . $html;

        $pdf = PDF::loadHTML($html);

        // Ensure the 'images' directory exists, create it if not
        $imagesDirectory = public_path('images');
        if (!file_exists($imagesDirectory)) {
            mkdir($imagesDirectory, 0755, true);
        }
        
        // Save the PDF to the public path
        $pdfPath = public_path('images/output.pdf');
        $pdf->save($pdfPath);

        
        // GENERATE PNG FROM PDF
        // Create Imagick object
        $imagick = new \Imagick();

        // Set resolution
        $imagick->setResolution(150, 150);
        
        // Read the PDF file
        $imagick->readImage($pdfPath);

        // Set quality (0-100)
        $imagick->setImageCompressionQuality(100);

        // Trim whitespace
        $imagick->trimImage(0);

        // Set the format to JPEG
        $imagick->setImageFormat('png');

        // Save the image to a file
        $outputImagePath = public_path('images/output.png');
        $imagick->writeImage($outputImagePath);

        // Clear Imagick resources
        $imagick->clear();
        $imagick->destroy();
        
        $url = url('images/output.png');

        return $url;
    }
}
