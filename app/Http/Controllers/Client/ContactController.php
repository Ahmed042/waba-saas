<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Client;

class ContactController extends Controller
{
    // Show contacts page
    public function index($company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $contacts = Contact::where('client_id', $client->id)->latest()->get();
        return view('client.contacts', compact('company', 'contacts'));
    }

    // Store new contact
    public function store(Request $request, $company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:contacts,phone,NULL,id,client_id,'.$client->id,
        ]);

        Contact::create([
            'client_id' => $client->id,
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return back()->with('success', 'Contact added!');
    }

    // Import contacts via CSV
    public function import(Request $request, $company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $row = 1;
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Assume columns: Name, Phone (first row is header)
            if ($row == 1) { $row++; continue; }
            $name = $data[0] ?? null;
            $phone = $data[1] ?? null;
            if (!$phone) continue;

            // Prevent duplicates for this client
            $exists = Contact::where('client_id', $client->id)->where('phone', $phone)->exists();
            if (!$exists) {
                Contact::create([
                    'client_id' => $client->id,
                    'name' => $name,
                    'phone' => $phone,
                ]);
            }
            $row++;
        }
        fclose($handle);
        return back()->with('success', 'Contacts imported!');
    }
}
