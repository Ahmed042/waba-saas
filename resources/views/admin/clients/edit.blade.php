@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Client</h1>

    <form method="POST" action="{{ route('admin.clients.update', $client->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ $client->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="{{ $client->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Bot Type:</label>
            <select name="bot_type" class="form-control">
                <option value="whatsapp" {{ $client->bot_type == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="voice" {{ $client->bot_type == 'voice' ? 'selected' : '' }}>Voice</option>
                <option value="email" {{ $client->bot_type == 'email' ? 'selected' : '' }}>Email</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Subscription Status:</label>
            <select name="subscription_status" class="form-control">
                <option value="trial" {{ $client->subscription_status == 'trial' ? 'selected' : '' }}>Trial</option>
                <option value="active" {{ $client->subscription_status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ $client->subscription_status == 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Message Quota:</label>
            <input type="number" name="message_quota" value="{{ $client->message_quota }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Client</button>
    </form>
</div>
@endsection
