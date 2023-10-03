<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/home_pages', [
            'title' => 'Dashboard'
        ]);
    }
}
