<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Client; // Or User if you use a unified users table

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm($company)
    {
        return view('client.login', compact('company'));
    }

    // Handle login
    public function login(Request $request, $company)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Find client by 'company' field (not company_slug)
    $client = \App\Models\Client::where('company', $company)->first();

    if (!$client) {
        return back()->withErrors(['company' => 'Invalid company URL.']);
    }

    // Check if email matches
    if ($client->email !== $request->email) {
        return back()->withErrors(['email' => 'Incorrect email or password.']);
    }

    // Validate password
    if (!\Illuminate\Support\Facades\Hash::check($request->password, $client->password)) {
        return back()->withErrors(['password' => 'Incorrect email or password.']);
    }

    // Log in (use your own auth/session logic)
    session(['client_id' => $client->id, 'company' => $company]);

    // Redirect to password update if not updated yet (add password_updated_at field if/when you implement)
    // if (!$client->password_updated_at) {
    //     return redirect()->route('client.password.update', ['company' => $company]);
    // }

    // Otherwise, redirect to dashboard
    if (!$client->password_updated_at) {
    return redirect()->route('client.password.update', ['company' => $company]);
}

    return redirect("/$company/dashboard");
}
// Show forced password update form
public function showUpdatePasswordForm($company)
{
    return view('client.update-password', compact('company'));
}

// Handle password update
public function updatePassword(Request $request, $company)
{
    $request->validate([
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $client = \App\Models\Client::where('company', $company)->first();

    if (!$client) {
        return back()->withErrors(['company' => 'Invalid company.']);
    }

    // Update password and mark as updated
    $client->password = \Illuminate\Support\Facades\Hash::make($request->password);
    $client->password_updated_at = now();
    $client->save();

    // Log in again, just in case
    session(['client_id' => $client->id, 'company' => $company]);

    return redirect("/$company/dashboard")->with('success', 'Password updated successfully!');
}

}
