@extends('client.app')

@section('content')
<div class="container py-4 px-2">
    <h3 class="fw-bold mb-4">API Settings</h3>
    <div class="card border-0 shadow-sm rounded-4" style="max-width:480px;">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-5 text-muted">Company Name</dt>
                <dd class="col-7">{{ $client->company }}</dd>

                <dt class="col-5 text-muted">Business Name</dt>
                <dd class="col-7">{{ $client->business_name ?? '--' }}</dd>

                <dt class="col-5 text-muted">WhatsApp Number</dt>
                <dd class="col-7">{{ $client->number_wa ?? '--' }}</dd>

                <dt class="col-5 text-muted">API Type</dt>
                <dd class="col-7">{{ $client->api_type ?? '--' }}</dd>

                <dt class="col-5 text-muted">Callback URL</dt>
                <dd class="col-7"><code>{{ $client->callback_url ?? '--' }}</code></dd>

                <dt class="col-5 text-muted">Phone ID</dt>
                <dd class="col-7"><code>{{ $client->phone_id ?? '--' }}</code></dd>

                <dt class="col-5 text-muted">Access Token</dt>
                <dd class="col-7"><code style="user-select:all;">{{ $client->access_token ?? '--' }}</code></dd>
            </dl>
            {{-- Optional: Add edit button or instructions --}}
        </div>
    </div>
</div>
@endsection
