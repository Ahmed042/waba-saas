<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  use App\Models\Template;
use App\Models\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;



class TemplateController extends Controller
{


// ... inside your TemplateController class

/**
 * Fetch all templates from Meta API for a given client
 */
protected function fetchMetaTemplates($client)
{
    $url = "https://graph.facebook.com/v19.0/{$client->waba_id}/message_templates";

    $response = Http::withToken($client->access_token)->get($url);

    if ($response->successful() && isset($response->json()['data'])) {
        return $response->json()['data']; // array of templates
    }

    return []; // fallback: no templates found or API error
}

    // List all templates for this client
public function index($company)
{
    $client = Client::where('company', $company)->firstOrFail();

    // 1. Fetch from Meta API
    $templates = $this->fetchMetaTemplates($client);

    // 2. Get local DB templates that are pending admin review (not yet sent to Meta)
    $pendingTemplates = \App\Models\Template::where('client_id', $client->id)
        ->where('status', 'pending_review')
        ->orderByDesc('id')
        ->get();

    return view('client.template.index', compact('company', 'templates', 'pendingTemplates'));
}

    // Show create form
    public function create($company)
    {
        return view('client.template.create', compact('company'));
    }


public function store(Request $request, $company)
{
    $request->validate([
        'name' => 'required',
        'language' => 'required',
        'body' => 'required',
    ]);
    $client = Client::where('company', $company)->firstOrFail();

    $template = Template::create([
        'client_id' => $client->id,
        'name' => $request->name,
        'language' => $request->language,
        'body' => $request->body,
        'status' => 'pending_review', // not pending or approved yet!
    ]);

    return redirect()->route('client.templates', ['company' => $company])
        ->with('success', 'Template submitted for admin review! Usually reviewed within 1 business day.');
}

}
