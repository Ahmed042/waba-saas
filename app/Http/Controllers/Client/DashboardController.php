<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index($company)
    {
        $client = \App\Models\Client::where('company', $company)->firstOrFail();

        // Counts
        $activeContacts = \App\Models\Contact::where('client_id', $client->id)
            ->where('status', 'active')->count();

        $messagesSent = \App\Models\Message::where('client_id', $client->id)->count();

        // Remaining messages
        $remainingMessages = max(0, $client->total_messages_allowed - $messagesSent);

        // Quota (as percent)
        $quota = $client->total_messages_allowed > 0
            ? round(100 * max(0, ($client->total_messages_allowed - $messagesSent)) / $client->total_messages_allowed)
            : 0;

        // Dynamic recent activity (show latest contacts/messages)
        $recentContacts = \App\Models\Contact::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->take(2)->get();

        $recentMessages = \App\Models\Message::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->take(2)->get();

        $recentActivity = [];

        foreach ($recentContacts as $contact) {
            $recentActivity[] = "Added new contact <b>" . e($contact->name ?? 'Contact') . "</b>";
        }
        foreach ($recentMessages as $msg) {
            $recentActivity[] = "Sent a message to <b>" . e($msg->to ?? 'Contact') . "</b> (" . e(\Illuminate\Support\Str::limit($msg->body ?? '', 30)) . ")";
        }

        // Fill with dummy if not enough activity
        $fallbackActivity = [
            "You sent <b>Broadcast Message</b> to <b>Sales Team</b> (300 contacts)",
            "Imported 500 new contacts from <b>marketing.csv</b>",
            "Added <b>Support Team</b> to Contact Lists",
            "Message template <b>New Offer</b> submitted for approval",
        ];

        if (count($recentActivity) < 4) {
            $recentActivity = array_merge($recentActivity, array_slice($fallbackActivity, 0, 4 - count($recentActivity)));
        }

        // Messaging Activity Chart Data (for this month)
        $daysInMonth = Carbon::now()->daysInMonth;
        $labels = [];
        $data = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::now()->startOfMonth()->addDays($d - 1)->format('Y-m-d');
            $labels[] = Carbon::now()->startOfMonth()->addDays($d - 1)->format('j M');
            $count = \App\Models\Message::where('client_id', $client->id)
                ->whereDate('created_at', $date)
                ->count();
            $data[] = $count;
        }

        return view('client.dashboard', compact(
            'company',
            'client',
            'activeContacts',
            'messagesSent',
            'quota',
            'remainingMessages',
            'recentActivity',
            'labels',
            'data'
        ));
    }
}
