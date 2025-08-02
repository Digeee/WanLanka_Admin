<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // You can pass any data needed to the view here
        return view('admin.dashboard');  // Make sure you have a view for the dashboard
    }
}
