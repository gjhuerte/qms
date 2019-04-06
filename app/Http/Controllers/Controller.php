<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use PDF;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function printPreview($view, $data = [], $filename = 'Preview.php')
    {
        $pdf = PDF::loadView($view, $data);
        // dd($filename);
        // return $pdf->download($filename);
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        $header = view('layouts.header-report');

        return $pdf->setOption('header-html', $header)
            ->setOption('header-spacing', 5)
            ->setOption('footer-center', 'Page [page]')
            ->stream($filename, ['Attachment'=>0]);
    }

    public function sanitizeString($var)
    {
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);

        return $var;
    }
}
