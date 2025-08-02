<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ListModel;

class ListController extends Controller
{
    // Show all lists
    public function index($company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $lists = ListModel::where('client_id', $client->id)->latest()->get();
        $contacts = Contact::where('client_id', $client->id)->get();

        return view('client.lists', compact('company', 'lists', 'contacts'));
    }

    // Store new list
    public function store(Request $request, $company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ListModel::create([
            'client_id' => $client->id,
            'name' => $request->name,
        ]);
        return back()->with('success', 'List created!');
    }

    // Assign contacts to list
    public function addContacts(Request $request, $company, $listId)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $list = ListModel::where('id', $listId)->where('client_id', $client->id)->firstOrFail();

        $request->validate([
            'contact_ids' => 'required|array',
        ]);

        $list->contacts()->syncWithoutDetaching($request->contact_ids);

        return back()->with('success', 'Contacts added to list!');
    }

    // Show contacts of a list
    public function showContacts($company, $listId)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $list = ListModel::where('id', $listId)->where('client_id', $client->id)->firstOrFail();
        $contacts = $list->contacts()->get();

        return view('client.list_contacts', compact('company', 'list', 'contacts'));
    }
}
