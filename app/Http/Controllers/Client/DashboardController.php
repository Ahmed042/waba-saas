<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($company)
    {
        // You can add logic to pass stats here later
        return view('client.dashboard', compact('company'));
    }
}
