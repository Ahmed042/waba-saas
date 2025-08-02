<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class SettingsController extends Controller
{
    public function index($company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        return view('client.settings', compact('company', 'client'));
    }
}
