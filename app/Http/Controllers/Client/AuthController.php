<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;

class AuthController extends Controller
{
    // Show the company login form
    public function showLoginForm($company)
    {
        return view('client.login', compact('company'));
    }

    // Handle login POST
    public function login(Request $request, $company)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the client/company by slug
        $client = Client::where('company', $company)->first();

        if (!$client) {
            return back()->withErrors(['company' => 'Invalid company URL.']);
        }

        if ($client->email !== $request->email) {
            return back()->withErrors(['email' => 'Incorrect email or password.']);
        }

        if (!Hash::check($request->password, $client->password)) {
            return back()->withErrors(['password' => 'Incorrect email or password.']);
        }

        // Set session keys for access control
        session([
            'client_id'    => $client->id,
            'company_slug' => $company, // This MUST match what your middleware checks
        ]);

        // Redirect to forced password update if needed
        if (!$client->password_updated_at) {
            return redirect()->route('client.password.update', ['company' => $company]);
        }

        // Always redirect to the correct company dashboard
        return redirect()->route('client.dashboard', ['company' => $company]);
    }

    // Show forced password update form
    public function showUpdatePasswordForm($company)
    {
        return view('client.update-password', compact('company'));
    }

    // Handle password update POST
    public function updatePassword(Request $request, $company)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $client = Client::where('company', $company)->first();

        if (!$client) {
            return back()->withErrors(['company' => 'Invalid company.']);
        }

        // Update password and mark as updated
        $client->password = Hash::make($request->password);
        $client->password_updated_at = now();
        $client->save();

        // Set session again to ensure access
        session([
            'client_id'    => $client->id,
            'company_slug' => $company,
        ]);

        return redirect()->route('client.dashboard', ['company' => $company])
            ->with('success', 'Password updated successfully!');
    }

    // Show company picker form (public)
    public function showCompanyPicker()
    {
        return view('auth.choose_company');
    }

    // Handle company picker POST (public)
    public function handleCompanyPicker(Request $request)
    {
        $request->validate(['company' => 'required']);
        $companySlug = strtolower(trim($request->input('company')));

        // Optional: Validate company exists before redirect
        if (!Client::where('company', $companySlug)->exists()) {
            return back()->withErrors(['company' => 'Company not found.']);
        }

        return redirect("/$companySlug/login");
    }

    // (Optional) Add logout for session flush
    public function logout($company)
    {
        session()->flush();
        return redirect("/$company/login");
    }
}
