<?php

namespace App\Http\Middleware;

use Closure;

class EnsureCompanyAccess
{
    public function handle($request, Closure $next)
    {
        $companySlug = $request->route('company');
        $sessionCompanySlug = session('company_slug');

        if (!$sessionCompanySlug) {
            return redirect('/choose-company');
        }
        if ($companySlug !== $sessionCompanySlug) {
            abort(403, 'Unauthorized company access');
        }
        return $next($request);
    }
}
