<?php

namespace Sosupp\SlimDashboard\Http\Controllers;

use Illuminate\Http\Request;
use Sosupp\SlimDashboard\Http\Controllers\Controller;


class SlimerDashboardController extends Controller
{
    public function index(Request $request)
    {
        
        return view('slim-dashboard::slimer');

    }
}

