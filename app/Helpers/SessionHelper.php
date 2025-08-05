<?php

if (!function_exists('company_check_or_redirect')) {
    /**
     * Checks if the current session is valid for the requested company.
     * If not, redirects to the company login page.
     *
     * @param string $company
     * @return \Illuminate\Http\RedirectResponse|null
     */
    function company_check_or_redirect($company)
    {
        if (!session('company_slug') || session('company_slug') !== $company) {
            // Optionally clear session: session()->flush();
            return redirect("/$company/login")->withErrors(['auth' => 'Please log in first.']);
        }
        // Session is valid, proceed
        return null;
    }
}
