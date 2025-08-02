@extends('layouts.app')

@section('content')
<div class="container">
    <h3>WhatsApp Logs</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Message</th>
                <th>Status</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->client?->name }}</td>
                <td>{{ $log->message }}</td>
                <td>{{ $log->status }}</td>
                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form method="GET" class="mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <select name="client_id" class="form-select">
                <option value="">-- Filter by Client --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>


    {{ $logs->links() }}
</div>
@endsection
