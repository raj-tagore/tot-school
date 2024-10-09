<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomSettings;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $announcement = CustomSettings::where('name', 'announcement')->first();
        return view('home', ['announcement' => $announcement]);
    }
}
