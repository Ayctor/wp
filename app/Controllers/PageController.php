<?php

namespace Ayctor\Controllers;

/**
 * Class PageController to manage pages views
 */
class PageController extends Controller
{
    /**
     * View for index.php
     * @return string Html for index page
     */
    public function index()
    {
        $toto = 'test';

        return $this->view('pages.index', compact('toto'));
    }

    /**
     * View for 404.php
     * @return string Html for 404 page
     */
    public function notFound()
    {
        return $this->view('pages.404');
    }
}
