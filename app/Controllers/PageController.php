<?php

namespace Ayctor\Controllers;

use WpCore\Controllers\Controller;

/**
 * Class PageController to manage pages views
 */
class PageController extends Controller
{
    /**
     * View for index.php
     *
     * @return string
     */
    public function index(): ?string
    {
        return $this->view('pages.index');
    }

    /**
     * View for 404.php
     *
     * @return string
     */
    public function notFound(): ?string
    {
        return $this->view('pages.404');
    }
}
