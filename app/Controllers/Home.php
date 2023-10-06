<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/cashier/dashboard_page', [
            'title' => 'Dashboard'
        ]);
    }
}
