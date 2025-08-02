<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsAppLog;
use App\Models\User;

class WhatsAppLogController extends Controller
{
    public function index(Request $request)
    {
        // Authorization check for super_admin role
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized');
        }

        // Fetch WhatsApp logs with optional client filtering
        $query = WhatsAppLog::with('client')->latest();

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $logs = $query->paginate(20);

        // Get list of clients for filter dropdown
        $clients = User::where('role', 'client')->get();

        return view('admin.whatsapp_logs.index', compact('logs', 'clients'));
        
    }

    public function show($id)
    {
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized');
        }

        $log = WhatsAppLog::with('client')->findOrFail($id);

        return view('admin.whatsapp_logs.show', compact('log'));
    }
}
