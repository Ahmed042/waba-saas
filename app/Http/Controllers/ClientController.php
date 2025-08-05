<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

public function store(Request $request)
{
    try {
        Log::info('Incoming client store request:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:6',
            'type' => 'required|in:official,non_official',
            'package_name' => 'nullable|string|max:255',
            'total_messages_allowed' => 'nullable|integer|min:0',
            'subscription_date' => 'nullable|date',
            'renewal_date' => 'nullable|date',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => $validated['type'],
            'role' => 'client',
            'package_name' => $validated['package_name'] ?? null,
            'total_messages_allowed' => $validated['total_messages_allowed'] ?? null,
            'subscription_date' => $validated['subscription_date'] ?? null,
            'renewal_date' => $validated['renewal_date'] ?? null,
        ];

        if ($validated['type'] === 'official') {
            $data['company'] = $request->input('company');
            $data['phone'] = $request->input('phone');
            $data['callback_url'] = $request->input('callback_url');
            $data['phone_id'] = $request->input('phone_id');
            $data['access_token'] = $request->input('access_token');
        } else {
            $data['number_wa'] = $request->input('number_wa');
            $data['api'] = $request->input('api');
        }

        $client = Client::create($data);

        Log::info('Client created successfully with ID: ' . $client->id);

        return redirect()->back()->with('success', 'Client created successfully.');
    } catch (\Exception $e) {
        Log::error('Failed to create client: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}


    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
    'name' => 'required|string',
    'email' => 'required|email|unique:clients,email,' . $client->id,
    'phone' => 'nullable|string',
    'business_name' => 'nullable|string',
    'country' => 'nullable|string',
    'api_type' => 'required|in:official,unofficial',
    'bot_type' => 'nullable|string',
    'business_type' => 'nullable|string',
    'status' => 'required|in:active,trial,suspended',
    // new fields:
    'package_name' => 'nullable|string|max:255',
    'total_messages_allowed' => 'nullable|integer|min:0',
    'subscription_date' => 'nullable|date',
    'renewal_date' => 'nullable|date',
]);


        $credentials = $request->only(['api_credentials']); // optional

        $client->fill($validated);
        $client->api_credentials = json_encode($credentials);
        $client->can_broadcast = $request->has('can_broadcast');
        $client->can_use_groups = $request->has('can_use_groups');
        $client->can_use_voice = $request->has('can_use_voice');
        $client->can_use_flows = $request->has('can_use_flows');
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted.');
    }
}
