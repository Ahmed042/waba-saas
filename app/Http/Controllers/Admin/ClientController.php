<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->latest()->get();
        return view('admin.clients.index', compact('clients'));
    }



public function store(Request $request)
{
    $type = $request->input('type');

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:official,non_official',
        'email' => $type === 'official' ? 'required|email|unique:clients,email' : 'nullable|email',
        'password' => $type === 'official' ? 'required|string|min:6' : 'nullable',
    ]);

    $client = new Client();
    $client->name = $request->name;
    $client->type = $type;

    if ($type === 'official') {
        $client->email = $request->email;
        $client->password = Hash::make($request->password);
        $client->company = $request->company;
        $client->phone = $request->phone;
        $client->callback_url = $request->callback_url;
        $client->phone_id = $request->phone_id;
        $client->access_token = $request->access_token;
    } else {
        $client->number_wa = $request->number_wa;
        $client->api = $request->api;
    }

    $client->role = 'client'; // default role
    $client->save();

    return redirect()->route('admin.clients.index')->with('success', 'Client added successfully.');
}


    public function update(Request $request, $id)
    {
        $client = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $client->id,
        ]);

        $client->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Client deleted.');
    }
}
