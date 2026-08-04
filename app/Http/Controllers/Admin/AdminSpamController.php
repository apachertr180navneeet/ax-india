<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminSpamController extends Controller
{
    public function index(): View
    {
        return view('admin.spam.index');
    }
}
