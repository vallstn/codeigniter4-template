<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (! auth()->user()) {
            return redirect()->to(ADMIN_AREA);
        }
		
		$user = auth()->user();
		
		//print_r($user); die;

        if ( $user->inGroup('public')) {
            return redirect()->to('/public/home');
        }

        return view('welcome_message');
    }
}
