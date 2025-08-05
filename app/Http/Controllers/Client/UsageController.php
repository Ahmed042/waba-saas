<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;

class UsageController extends Controller
{
    public function index($company)
{
    $client = \App\Models\Client::where('company', $company)->firstOrFail();
    // Pass $company to the view!
    return view('client.usage', compact('client', 'company'));
}

}
