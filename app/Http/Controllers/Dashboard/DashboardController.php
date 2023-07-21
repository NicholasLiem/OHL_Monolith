<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        return view('dashboard');
    }

}
