<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TwoFactorController extends Controller
{
    public function index(): View
    {
        return view('settings.two-factor');
    }
}
