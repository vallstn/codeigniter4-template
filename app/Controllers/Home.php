<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (! auth()->user()) {
            return redirect()->to(ADMIN_AREA);
        }

        return view('welcome_message');
    }
}
