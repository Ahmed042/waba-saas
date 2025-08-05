@extends('client.app')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Usage Details for {{ $client->business_name ?? $client->name }}
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Client Name</th>
                    <td>{{ $client->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $client->email }}</td>
                </tr>
                <tr>
                    <th>Package Name</th>
                    <td>{{ $client->package_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Messages Allowed</th>
                    <td>{{ $client->total_messages_allowed ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Subscription Date</th>
                    <td>{{ $client->subscription_date ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Renewal Date</th>
                    <td>{{ $client->renewal_date ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-{{ $client->status === 'active' ? 'success' : ($client->status === 'trial' ? 'warning' : 'danger') }}">
                            {{ ucfirst($client->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
