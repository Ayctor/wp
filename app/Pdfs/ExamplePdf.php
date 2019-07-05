<?php

namespace Ayctor\Pdfs;

use WpCore\Pdfs\Pdf;

class ExamplePdf extends Pdf
{
    public function __construct()
    {
        $example = 'example';

        ob_start();
        	$this->view('pdfs.example', compact('example'));
            $this->content = ob_get_contents();
        ob_end_clean();
    }
}
