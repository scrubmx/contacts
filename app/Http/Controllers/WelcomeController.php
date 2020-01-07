<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    /**
     * WelcomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->only('index');
    }

    /**
     * Show the application welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke() : View
    {
        return view('welcome');
    }
}
